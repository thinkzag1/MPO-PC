<?php

namespace Concrete\Package\Poptin\Controller\SinglePage\Dashboard\System;

use Core;
use Concrete\Core\Package\Package;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Url\Resolver\PathUrlResolver;
use Concrete\Core\Support\Facade\Package as PackageFacade;
use Concrete\Core\View\View;
use Concrete\Core\Routing\Redirect;


define('POPTIN_MARKETPLACE', 'cncrt');
define('POPTIN_DASHBOARD_URL', 'https://app.popt.in/overview');
define('POPTIN_MARKETPLACE_LOGIN_URL', 'https://app.popt.in/api/marketplace/auth');
define('POPTIN_MARKETPLACE_REGISTER_URL', 'https://app.popt.in/api/marketplace/register');

final class Poptin extends DashboardPageController
{

    public function view()
    {
        $this->addPoptinScript();

        /**
         *
         * Admin Initialization calls registration
         * We need this to send user to Poptin's Admin page on activation
         *
         */
        $data = $this->request->query->all();
        if(!empty($data['page'])) {
            $after_registration = '';
            if(!empty($data['after_registration'])) {
                $after_registration = $data['after_registration'];
            }
            $this->poptin_markplace_login_direct($after_registration);
        }

        $pkg = PackageFacade::getByHandle('poptin');
        $packagePath = $pkg->getRelativePath();
        
        $this->set('poptin_id_check', $this->getPoptinId());
        $this->set('poptin_marketplace_token_check', $this->getMarketplaceToken());
        $this->set('poptin_marketplace_email_id_check', $this->getMarketplaceEmail());
        $this->set('go_to_dashboard_url', $this->getDashboardUrl());
        $this->set('assets', $packagePath . '/images');

        $this->addFooterItem($this->app->make('helper/html')->javascript($packagePath . '/js/bootstrap.min.js', 'bootstrap'));
        $this->addFooterItem($this->app->make('helper/html')->javascript($packagePath . '/js/poptin-admin.js', 'poptinjs'));
        $this->addHeaderItem($this->app->make('helper/html')->css($packagePath . '/css/bootstrap-min.css', 'bootstrap'));
        $this->addHeaderItem($this->app->make('helper/html')->css($packagePath . '/css/poptin-admin.css', 'poptincss'));

        
    }

    public function on_page_view() {
        
        $poptinidcheck = $this->getPoptinId();
        if ($poptinidcheck) {
            $poptinid = $this->getPoptinId();
            if (strlen($poptinid) == 13) {
                $html = $this->app->make('helper/html');
                $v = View::getInstance();
                $v->addHeaderItem('<script id="pixel-script-poptin" src="https://cdn.popt.in/pixel.js?id=' . $poptinid . '" async="true"></script>');
            }
        }
    }

    /**
     *
     *
     * Scope:       Private
     * Function:    poptin_marketplace_registration
     * Description: Will be called via the Admin Page AJAX
     *              Will be checked with WP nounce.
     *              If the verification is OK, we go ahead and create the account.
     *              Email Address - Would be pre-filled in the form in the Admin Page.
     *              User wants, can change the email id.
     *              We store the registration email ID, to ensure that we do not have issues in future.
     *              Basic wrapper function to the poptin_middleware_registration_curl
     *              Responds in JSON from the cURL call.
     * Parameters:  email   (argument)
     *              domain      -   retrieved from the Wordpress base.
     *              first_name  -   derived from the nice_name of the existing logged in user.
     *              last_name  -   derived from the nice_name of the existing logged in user.
     * Return:      Return response is derived directly from the chain function poptin_middleware_registration_curl
     *
     *
     */
    function poptin_marketplace_registration()
    {
        $email =  $this->request->request->get('email');
        
        /**
         *
         * We check the sanitization here again for the email id.
         * This is for AJAX call, hence the double check is required.
         * If this is okay, we go ahead and send the data poptin_marketplace_registration function.
         *
         */
        if (!$email) {
            $return_array = array();
            $return_array['success'] = false;
            $return_array['message'] = t('Invalid Email Address found.');
            return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($return_array);
        }

        $domain = BASE_URL;
        
        // TODO: Replace them with actual values
        $first_name = '';
        $last_name = '';
        
        $response = $this->poptin_middleware_registration_curl($first_name, $last_name, $domain, $email);
        return $response;
    }

    /**
     *
     *
     * Scope:       Private
     * Function:    poptin_middleware_registration_curl
     * Description: 
     * Arguments:
     * Return:      JSON Response
     *
     *
     **/
    private function poptin_middleware_registration_curl($first_name, $last_name, $domain, $email)
    {
        $curl_URL = POPTIN_MARKETPLACE_REGISTER_URL;
        $curl_post_array = array(
            'domain' => $domain,
            'marketplace' => POPTIN_MARKETPLACE,
            'email' => $email
        );

        $curl_options = $this->generate_curl_options($curl_URL, $curl_post_array);
        $curl = curl_init();
        curl_setopt_array($curl, $curl_options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response_return_array = array();
        if ($err) {
            $response_return_array['success'] = false;
            $response_return_array['message'] = t("Internal error occurred. Please try again later.");
            $response_return_array['error'] = $err;
            return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
        } else {
            $response_array = json_decode($response);
            if ($response_array->success) {
                $response_return_array['success'] = true;
                $response_return_array['message'] = t("Registration successful");
                $response_return_array['js_client_id'] = $response_array->client_id;
                $response_return_array['user_token'] = $response_array->token;


                /**
                 * On Success
                 * We setup the update options
                 */

                $config = $this->app->make(Repository::class);
                $config->save('poptin.id', (string) $response_array->client_id);
                $config->save('poptin.user_id', (string) $response_array->user_id);
                $config->save('poptin.marketplace_token', (string) $response_array->token);
                $config->save('poptin.marketplace_email_id', (string) $email);
                return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
            } else {
                $response_return_array['success'] = false;
                $response_return_array['message'] = $response_array->message;
                return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
            }
        }
    }

    /**
     *
     *
     * Function:    poptin_markplace_login_direct
     * Description: Based on the variables stored in config
     *              We make request to the marketplace api for login
     *              In simpler terms this is a wrapper function for making AJAX call -> to cURL call -> to respond back.
     * Parameters:  POST Data NOT required
     *              - token [Generated at the time of registration from the marketplace API ONLY]
     *              - email [Email ID used at the time of registration from the marketplace API ONLY]
     * Return:      login_url   -   if it went successful
     *              success     -   true/false
     *
     *
     */
    function poptin_markplace_login_direct($after_registration='') {
        $config = $this->app->make(Repository::class);

        $token = $this->getMarketplaceToken();
        $user_id = $this->getPoptinUserId();
        $curl_URL = POPTIN_MARKETPLACE_LOGIN_URL;
        $curl_post_array = array(
            'token' => $token,
            'user_id' => $user_id
        );
        $curl_options = $this->generate_curl_options($curl_URL, $curl_post_array);
        $curl = curl_init();
        curl_setopt_array($curl, $curl_options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response_return_array = array();
        if ($err) {
            $response_return_array['success'] = false;
            return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
        } else {
            $response_array = json_decode($response);
            if ($response_array->success) {
                $login_url = $response_array->login_url;
                // If user just registered
                if($after_registration != '') {
                    $login_url .= '&utm_source=concrete5';
                }
                return $this->redirect($login_url);
            } else {
                return $this->redirect('/dashboard/system/poptin');
            }
        }
        return $this->redirect('/dashboard/system/poptin');
    }

    /**
     *
     *
     * Function:    poptin_deactivate
     * Description: Deactivate the poptin plugin by deleting the items from config for this app.
     * Return:      response object with success value and message
     *
     *
     */
    function poptin_deactivate() {

        // Remove poptin script
        $this->removePoptinScript();

        // Remove config variables
        $config = $this->app->make(Repository::class);
        $config->save('poptin.id', '');
        $config->save('poptin.user_id', '');
        $config->save('poptin.marketplace_token', '');
        $config->save('poptin.marketplace_email_id', '');

        $response_return_array = array();
        $response_return_array['success'] = true;
        $response_return_array['message'] = t("Poptin plugin deactivated.");
        return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
    }

    /**
     * Scope:       Private
     * Function:    generate_curl_options
     * Description: This is Utility Function generates the POST cURL calls options.
     *              Have placed a function to ensure it remains generic and updates do not require many changes.
     *              Uses the CA Cert certificate.
     * Return:      Array | Options Array for cURL Post method call.
     **/
    private function generate_curl_options($curl_URL, $curl_post_array)
    {
        $curl_options_array = array(
            CURLOPT_URL => $curl_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 20,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $curl_post_array
        );
        return $curl_options_array;
    }

    /**
     * Scope:       Public
     * Function:    poptin_add_id
     * Description: AJAX wrapper for adding Poptin ID, only used when user enters the Poptin ID manually.
     * Parameters:  None
     */
    function poptin_add_id()
    {
        $post_data = $this->request->request->get('data');
        if (!empty($post_data['poptin_id'])) {
            $poptin_id = $post_data['poptin_id'];
            // Add poptin id in config
            $config = $this->app->make(Repository::class);
            $config->save('poptin.id', $poptin_id);

            $this->addPoptinScript();

            $response_return_array = array(
                'success' => true,
                'message' => t('Database updated successfully.')
            );
            return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
        } else {
            $response_return_array = array(
                'success' => false,
                'message' => t('Wrong id.')
            );
            return $this->app->make(\Concrete\Core\Http\ResponseFactoryInterface::class)->json($response_return_array);
        }

    }

    private function addPoptinScript() {
        $config = $this->app->make('site')->getSite()->getConfigRepository();

        $poptinidcheck = $this->getPoptinId();
        if ($poptinidcheck) {
            $poptinid = $this->getPoptinId();
            
            if (strlen($poptinid) == 13) {
                $script = '<script id="pixel-script-poptin" src="https://cdn.popt.in/pixel.js?id=' . $poptinid . '" async="true"></script>';
                
                $existing_code = $config->get('seo.tracking.code.header');
                $existing_code = str_replace($script, "", $existing_code);
                $new_code = $existing_code . $script;
                $config->save('seo.tracking.code.header', $new_code);
            }
        }
    }

    private function removePoptinScript() {
        $config = $this->app->make('site')->getSite()->getConfigRepository();

        $poptinidcheck = $this->getPoptinId();
        if ($poptinidcheck) {
            $poptinid = $this->getPoptinId();
            
            if (strlen($poptinid) == 13) {
                $script = '<script id="pixel-script-poptin" src="https://cdn.popt.in/pixel.js?id=' . $poptinid . '" async="true"></script>';
                
                $existing_code = $config->get('seo.tracking.code.header');
                $existing_code = str_replace($script, "", $existing_code);
                $new_code = $existing_code;
                $config->save('seo.tracking.code.header', $new_code);
            }
        }
    }


    /**
     * @return string
     */
    private function getPoptinId()
    {
        $config = $this->app->make(Repository::class);
        return $config->get('poptin.id') ?: '';
    }

    /**
     * @return string
     */
    private function getPoptinUserId()
    {
        $config = $this->app->make(Repository::class);
        return $config->get('poptin.user_id') ?: '';
    }

    /**
     * @return string
     */
    private function getMarketplaceToken()
    {
        $config = $this->app->make(Repository::class);
        return $config->get('poptin.marketplace_token') ?: '';
    }

    /**
     * @return string
     */
    private function getMarketplaceEmail()
    {
        $config = $this->app->make(Repository::class);
        return $config->get('poptin.marketplace_email_id') ?: '';
    }

    /**
     * @return string
     */
    private function getDashboardUrl()
    {
        $config = $this->app->make(Repository::class);
        return $config->get('poptin.dashboard_url') ?: POPTIN_DASHBOARD_URL;
    }
}
