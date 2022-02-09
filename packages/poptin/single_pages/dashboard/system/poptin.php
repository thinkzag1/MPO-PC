<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var $form \Concrete\Core\Form\Service\Form */
/** @var $token \Concrete\Core\Validation\CSRF\Token */
/** @var $config \Concrete\Core\Config\Repository\Repository */
/** @var $shouldShowSubscribeButton bool */
/** @var $linkToPoptinPortal string */
/** @var $showJobScheduleSection bool */
/** @var $endpoint string */
/** @var $apiMethods array */

if ($poptin_marketplace_token_check && $poptin_marketplace_email_id_check) {
    $go_to_dashboard_url = "poptin?page=Poptin&poptin_logmein=true";
}
?>

<!-- Main wrapper -->
<div class="poptin-overlay"></div>
<div class="wrap poptinWrap">
    <!-- Logo -->
    <div class="poptinLogo"><img src="<?php echo $assets . '/poptinlogo.png' ?>"/></div>

    <div class="poptinLogged" style="<?php echo($poptin_id_check ? 'display:block' : 'display:none') ?>">
        <!-- Here will render after login/create account view -->
        <div class="poptinLoggedBg"
             style="background:url(<?php echo $assets . '/loggedinbg.png' ?>) no-repeat">
            <form id="logmein_form" action="" method="POST">
                <input type="hidden" name="action" value="poptin_logmein" class="poptin_input"/>
                <input type="hidden" name="logmein" value="true" class="poptin_input"/>
            </form>
            <h2 class="loggedintitle"><?php echo t("You're all set!"); ?></h2>
            <div class="tinyborder"></div>
            <span class="everythinglooks"><?php echo t("Click on the button below<br>to manage your poptins"); ?></span>
            <img src="<?php echo $assets . '/vicon.png' ?>"/>
            <a href="<?php echo $go_to_dashboard_url; ?>" target="_blank"
               class="ppcontrolpanel goto_dashboard_button_pp_updatable"><?php echo t("Go to Dashboard"); ?></a>
            <a href="#logout" class="pplogout"><?php echo t("Deactivate Poptin"); ?></a>
        </div>

        <div class="clearfix"></div>
        <div class="poptinContent review">
            <h2 class="poptinTitle"><?php echo t("Let us know what you think "); ?>🙂</h2>
            <div class="tinyborder"></div>
            <div class="reviewbox"
                 style="background:url(<?php echo $assets . '/reviewframe.png' ?>) no-repeat">
                <div class="reviewtitle">
                    <?php echo t("If Poptin already helped you to grow your business, please click on the button below and leave a positive review"); ?>
                    <?php /*<img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/2.4/svg/1f642.svg">*/ ?>🙂
                </div>
                <div class="reviewstars">
                    <img src="<?php echo $assets . '/stars.png' ?>"/>
                </div>
                <div class="reviewlink">
                    <a href="https://www.concrete5.org/marketplace/addons/website-popups-email-popup-exit-intent-popup-and-forms-poptin/reviews"
                       target="_blank"><?php echo t("Write a Review"); ?></a>
                </div>
            </div>
        </div>

    </div>


    <div class="ppaccountmanager" style="<?php echo($poptin_id_check ? 'display:none' : 'display:block') ?>">
        <div class="popotinRegister">
            <!-- Here will render register view -->
            <div class="accountWrapper"
                 style="background:url(<?php echo $assets . '/accountboxsignup.png' ?>) no-repeat">
                <div class="poptinWrapInner">
                    <div class="topAccountBar sign_up_for_free_wrapper">
                        <span class="ppRegister active"><?php echo t("Sign up for free"); ?></span>
                        <span class="ppSeparator"></span>
                        <a href="#" class="ppLogin"><?php echo t("Already have an account?"); ?></a>
                        <div class="clearfix"></div>
                    </div>
                    <form id="registration_form" class="ppFormRegister ppForm" action="<?php echo $this->action('poptin_marketplace_registration'); ?>" 
                        method="POST">

                        <input class="poptin_input" type="text" id="email" name="email" placeholder="Enter your email"
                               value="<?php //echo $admin_email; ?>"
                               placeholder="example@poptin.com"/>
                        <input type="hidden" name="action" class="poptin_input" value="poptin_register"/>
                        <input type="hidden" name="register" class="poptin_input" value="true"/>
                        <div class="bottomForm">
                            <input class="ppSubmit pp_signup_btn poptin_signup_button" type="submit"
                                   value="<?php echo t("Sign Up"); ?>"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="popotinLogin" style="display:none">
            <!-- Here will render login view -->
            <div class="accountWrapper"
                 style="background:url(<?php echo $assets . '/accountbox.png' ?>) no-repeat">
                <div class="poptinWrapInner">
                    <div class="topAccountBar poptin_login_wrapper">
                        <span class="ppLogin active"><?php echo t("Enter your user ID"); ?></span><span
                                class="ppSeparator"></span><a href="#"
                                                              class="ppRegister"><?php echo t("Sign up for free"); ?></a>
                    </div>
                    <form id="map_poptin_id_form" class="ppFormLogin ppForm" action="<?php echo $this->action('poptin_add_id'); ?>">
                        <input type="text" value="" placeholder="Enter your User ID" class="poptin_input"/>
                        <div class="bottomForm remove_top_margin">
                            <a href="#" data-toggle="modal" data-target="#whereIsMyId"
                               class="wheremyid"><?php echo t("Where is my user ID?"); ?></a>
                            <input class="ppSubmit poptin_submit_button" type="submit" value="<?php echo t("Connect"); ?>"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="poptinContent">
            <h2 class="poptinTitle"><?php echo t("Create your first poptin with ease"); ?></h2>
            <div class="tinyborder"></div>
            <div class="youtubeVideoContainer"
                 style="background:url(<?php echo $assets . '/youtubeBackground.png' ?>) no-repeat">
                <div class="youtubeVideo">
                    <iframe width="905" height="509"
                            src="https://www.youtube.com/embed/R_B8L3abt7Q?rel=0&amp;showinfo=0" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="poptinContent whyChoose">
            <h2 class="poptinTitle"><?php echo t("Here’s What Poptin Can Do For You"); ?></h2>
            <div class="tinyborder"></div>
            <div class="innerContent">
                <div class="box boxEnv">
                    <div class="boxIcon"><img src="<?php echo $assets . '/envelope.png' ?>"/></div>
                    <div class="boxTitle"><?php echo t("Get more email subscribers"); ?></div>
                </div>
                <div class="box boxLeads">
                    <div class="boxIcon"><img src="<?php echo $assets . '/fanel.png' ?>"/></div>
                    <div class="boxTitle"><?php echo t("Get more leads and sales"); ?></div>
                </div>
                <div class="box boxCart">
                    <div class="boxIcon"><img src="<?php echo $assets . '/wheel.png' ?>"/></div>
                    <div class="boxTitle"><?php echo t("Reduce shopping cart abandonment"); ?></div>
                </div>
                <div class="box boxHeart">
                    <div class="boxIcon"><img src="<?php echo $assets . '/heart.png' ?>"/></div>
                    <div class="boxTitle"><?php echo t("Increase visitors' engagement"); ?></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="poptinContent clients">
            <h2 class="poptinTitle"><?php echo t("Digital Marketers ♥ Poptin"); ?></h2>
            <div class="tinyborder"></div>
            <div class="innerContent">
                <div class="boxclient client1">
                    <div class="boxclientHead"
                         style="background:url(<?php echo $assets . '/client1bg.png' ?>) no-repeat">
                        <img src="<?php echo $assets . '/profile1.png' ?>"/>
                    </div>
                    <div class="clientboxtext">
                        <span class="clientName"><?php echo t("Michael Kamleitner"); ?></span>
                        <span class="clientCompany"><?php echo t("CEO, Walls.io"); ?></span>
                        <?php echo t("Getting started with poptin was a breeze – we've implemented the widget and connected it to our newsletter within minutes. Our conversion rate skyrocketed!"); ?>
                    </div>
                </div>
                <div class="boxclient client2">
                    <div class="boxclientHead"
                         style="background:url(<?php echo $assets . '/client2bg.png' ?>) no-repeat">
                        <img src="<?php echo $assets . '/profile2.png' ?>"/>
                    </div>
                    <div class="clientboxtext">
                        <span class="clientName"><?php echo t("Deepak Shukla"); ?></span>
                        <span class="clientCompany"><?php echo t("CEO, Purr Traffic"); ?></span>
                        <?php echo t("Been v.impressed with Poptin and the team behind it so far. Great responses times from support. The roadmap looks great. I highly recommend."); ?>
                    </div>
                </div>
                <div class="boxclient client3">
                    <div class="boxclientHead"
                         style="background:url(<?php echo $assets . '/client3bg.png' ?>) no-repeat">
                        <img src="<?php echo $assets . '/profile3.png' ?>"/>
                    </div>
                    <div class="clientboxtext">
                        <span class="clientName"><?php echo t("Michael Voiskoun"); ?></span>
                        <span class="clientCompany"><?php echo t("Marketing manager, Engie"); ?></span>
                        <?php echo t("It's super easy to use, doesn't require any prior coding skill. The team at Poptin is really helpful, providing great support, and adding always more features!"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="poptinContent review">
            <h2 class="poptinTitle"><?php echo t("Let us know what you think "); ?>🙂</h2>
            <div class="tinyborder"></div>
            <div class="reviewbox"
                 style="background:url(<?php echo $assets . '/reviewframe.png' ?>) no-repeat">
                <div class="reviewtitle">
                    <?php echo t("If Poptin already helped you to grow your business, please click on the button below and leave a positive review"); ?>
                    <?php /*<img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/2.4/svg/1f642.svg">*/ ?>🙂
                </div>
                <div class="reviewstars">
                    <img src="<?php echo $assets . '/stars.png' ?>"/>
                </div>
                <div class="reviewlink">
                    <a href="https://www.concrete5.org/marketplace/addons/website-popups-email-popup-exit-intent-popup-and-forms-poptin/reviews"
                       target="_blank"><?php echo t("Write a Review"); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="poptinContent footer">
        <script>
            jQuery(function ($) {
                $(".parrot").hover(
                    function () {
                        $(this).attr("src", "<?php echo $assets . '/parrot.gif' ?>");
                    },
                    function () {
                        $(this).attr("src", "<?php echo $assets . '/parrot.png' ?>");
                    }
                );
            });
        </script>
        <img class="parrot" src="<?php echo $assets . '/parrot.png' ?>"/>
        <span class="poptinlove"><?php echo t("Visit us at "); ?> <a
                    href="https://www.poptin.com/?utm_source=concrete5"
                    target="_blank">poptin.com</a></span>
        <p class="poptingdpr"> <a
                    href="https://www.poptin.com/gdpr?utm_source=concrete5"
                    target="_blank"><?php echo t("Learn more"); ?></a> <?php echo t("about %s and %s", "Poptin", "GDPR"); ?></p>
    </div>
</div>

<!-- Modal -->
<div id="whereIsMyId" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox">
        <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <div class="poptin-lightbox-header"><?php echo t("Where is my user ID?"); ?></div>
        <div class="poptin-where-my-id-wrapper">
            <div class="poptin-where-my-id-01">
                <img class="where-my-id-3-images"
                     src="<?php echo $assets . '/where-is-my-id-01.png' ?>"/>
                <div class="poptin-where-my-id-smalltext">
                    <b>1.</b>&nbsp;<?php echo t("Go to your dashboard, in the top bar click on \"Settings\""); ?>
                </div>
            </div>
            <div class="poptin-where-my-id-02">
                <img class="where-my-id-3-images"
                     src="<?php echo $assets . '/where-is-my-id-02.png' ?>"/>
                <div class="poptin-where-my-id-smalltext">
                    <b>2.</b>&nbsp;<?php echo t("Click on Profile"); ?>
                </div>
            </div>
            <div class="poptin-where-my-id-03">
                <img class="where-my-id-3-images"
                     src="<?php echo $assets . '/where-is-my-id-03.png' ?>"/>
                <div class="poptin-where-my-id-smalltext">
                    <b>3.</b>&nbsp;<?php echo t("Copy your user ID"); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-right">
            <div class="poptin-lightbox-button" data-dismiss="modal"><?php echo t("Close"); ?></div>
        </div>
    </div>
</div>

<!-- BYE BYE Modal -->
<div id="byebyeModal" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox-general">
        <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <img class="poptin-parrot-byebye-image" src="<?php echo $assets . '/parrot-bye-bye.png' ?>"/>
        <div class="poptin-lightbox-header-general"><?php echo t("Bye Bye"); ?></div>
        <div class="poptin-lightbox-textcontent-general">
            <?php echo t("Poptin snippet has been"); ?>
            <?php echo t("removed. See you around."); ?>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-center">
            <div class="poptin-lightbox-button" data-dismiss="modal"><?php echo t("Close"); ?></div>
        </div>
    </div>
</div>

<!-- Just Making Sure Modal -->
<div id="makingsure" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox-general">
        <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <img class="poptin-parrot-makingsure-image"
             src="<?php echo $assets . '/parrot-making-sure.png' ?>"/>
        <div class="poptin-lightbox-header-general"><?php echo t("Just making sure"); ?></div>
        <div class="poptin-lightbox-textcontent-general">
            <?php echo t("Are you sure you want to"); ?><br/> <?php echo t("remove Poptin?"); ?>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-center">
            <input type="hidden" id="poptin-deactivate" name="poptin-deactivate" value="<?php echo $this->action('poptin_deactivate'); ?>" />
            <div class="poptin-lightbox-button deactivate-poptin-confirm-yes"><?php echo t("Yes"); ?></div>
            <div class="poptin-lightbox-atag" data-dismiss="modal"><?php echo t("I'll stay"); ?></div>
        </div>
    </div>
</div>

<!-- Just Making Sure Modal -->
<div id="lookfamiliar" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox-general">
        <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <img class="poptin-parrot-familiar-image"
             src="<?php echo $assets . '/parrot-familiar.png' ?>"/>
        <div class="poptin-lightbox-header-general"><?php echo t("You look familiar"); ?></div>
        <div class="poptin-lightbox-textcontent-general">
            <?php echo t("You already have a Poptin"); ?><br/> <?php echo t("account with this email address."); ?>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-center">
            <a class="poptin-lightbox-button login-from-lb" target="_blank" href="https://app.popt.in/login"><?php echo t("Login"); ?></a>
            <div class="poptin-lightbox-atag" data-dismiss="modal"><?php echo t("Cancel"); ?></div>
        </div>
    </div>
</div>


<!-- Wrong Email ID Modal -->
<div id="oopsiewrongemailid" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox-general">
    <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <img class="poptin-parrot-oopsie-image" src="<?php echo $assets . '/parrot-oopsie.png' ?>"/>
        <div class="poptin-lightbox-header-general"><?php echo t("Oopsie... wrong Email"); ?></div>
        <div class="poptin-lightbox-textcontent-general">
            <?php echo t("Please enter a valid Email Address."); ?>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-center">
            <div class="poptin-lightbox-button" data-dismiss="modal"><?php echo t("Try again"); ?></div>
        </div>
    </div>
</div>

<!-- Just Making Sure Modal -->
<div id="oopsiewrongid" class="modal fade" role="dialog" style="margin-top: 110px;direction: ltr;">
    <div class="modal-dialog poptin-lightbox-general">
    <div class="closeBtn" data-dismiss="modal"><img src="<?php echo $assets . '/icons8-cross-mark-48.png' ?>" /></div>
        <img class="poptin-parrot-oopsie-image" src="<?php echo $assets . '/parrot-oopsie.png' ?>"/>
        <div class="poptin-lightbox-header-general"><?php echo t("Oopsie... wrong ID"); ?></div>
        <div class="poptin-lightbox-textcontent-general">
            <a href="#" class="poptin-lightbox-atag where-is-my-id-inside-lb"><?php echo t("Where is my user ID?"); ?></a>
        </div>
        <div class="clearfix"></div>
        <div class="poptin-lightbox-button-wrapper text-align-center">
            <div class="poptin-lightbox-button" data-dismiss="modal"><?php echo t("Try again"); ?></div>
        </div>
    </div>
</div>

<form action="https://app.popt.in/login" method="GET" class="dummy_form" id="dummy_form" target="_blank">

</form>














