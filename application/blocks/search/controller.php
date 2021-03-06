<?php
namespace Application\Block\Search;

use Concrete\Core\Attribute\Key\CollectionKey;
use Database;
use CollectionAttributeKey;
use Concrete\Core\Page\PageList;
use Concrete\Core\Block\BlockController;
use Page;
use Core;
use Request;

class Controller extends BlockController
{
    protected $btTable = 'btSearch';
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "420";
    protected $btWrapperClass = 'ccm-ui';
    protected $btExportPageColumns = array('postTo_cID');
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = null;

    public $title = "";
    public $buttonText = ">";
    public $baseSearchPath = "";
    public $resultsURL = "";
    public $postTo_cID = "";

    protected $hColor = '#EFE795';

    public function highlightedMarkup($fulltext, $highlight)
    {
        if (!$highlight) {
            return $fulltext;
        }

        $this->hText = $fulltext;
        $this->hHighlight = $highlight;
        $this->hText = @preg_replace('#' . preg_quote($this->hHighlight, '#') . '#ui', '<span style="background-color:'. $this->hColor .';">$0</span>', $this->hText);

        return $this->hText;
    }

    public function highlightedExtendedMarkup($fulltext, $highlight)
    {
        $text = @preg_replace("#\n|\r#", ' ', $fulltext);

        $matches = array();
        $highlight = str_replace(array('"', "'", "&quot;"), '', $highlight); // strip the quotes as they mess the regex

        if (!$highlight) {
            $text = Core::make('helper/text')->shorten($fulltext, 180);
            if (strlen($fulltext) > 180) {
                $text .= '&hellip;<wbr>';
            }

            return $text;
        }

        $regex = '([[:alnum:]|\'|\.|_|\s]{0,45})'. preg_quote($highlight, '#') .'([[:alnum:]|\.|_|\s]{0,45})';
        preg_match_all("#$regex#ui", $text, $matches);

        if (!empty($matches[0])) {
            $body_length = 0;
            $body_string = array();
            foreach ($matches[0] as $line) {
                $body_length += strlen($line);

                $r = $this->highlightedMarkup($line, $highlight);
                if ($r) {
                    $body_string[] = $r;
                }
                if ($body_length > 150) {
                    break;
                }
            }
            if (!empty($body_string)) {
                return @implode("&hellip;<wbr>", $body_string);
            }
        }
    }

    public function setHighlightColor($color)
    {
        $this->hColor = $color;
    }

    /**
     * Used for localization. If we want to localize the name/description we have to include this.
     */
    public function getBlockTypeDescription()
    {
        return t("Add a search box to your site.");
    }

    public function getBlockTypeName()
    {
        return t("Search");
    }

    public function __construct($obj = null)
    {
        parent::__construct($obj);
    }

    public function indexExists()
    {
        $db = Database::connection();
        $numRows = $db->GetOne('select count(cID) from PageSearchIndex');

        return $numRows > 0;
    }

    public function cacheBlockOutput()
    {
        if ($this->btCacheBlockOutput === null) {
            $this->btCacheBlockOutput = (($this->postTo_cID !== '' || $this->resultsURL !== '') && Request::request('query') === null);
        }

        return $this->btCacheBlockOutput;
    }

    public function view()
    {
        $c = Page::getCurrentPage();
        $this->set('title', $this->title);
        $this->set('buttonText', $this->buttonText);
        $this->set('baseSearchPath', $this->baseSearchPath);
        $this->set('postTo_cID', $this->postTo_cID);

        $resultsURL = $c->getCollectionPath();
        $resultsPage = null;

        if ($this->resultsURL != '') {
            $resultsURL = $this->resultsURL;
        } elseif ($this->postTo_cID != '') {
            $resultsPage = Page::getById($this->postTo_cID);
            $resultsURL = $resultsPage->getCollectionPath();
        }

        $resultsURL = Core::make('helper/text')->encodePath($resultsURL);

        $this->set('resultTargetURL', $resultsURL);
        if (is_object($resultsPage)) {
            $this->set('resultTarget', $resultsPage);
        } else {
            $this->set('resultTarget', $resultsURL);
        }

        //run query if display results elsewhere not set, or the cID of this page is set
        if ($this->postTo_cID == '' && $this->resultsURL == '') {
            $request = Request::getInstance();
            if (((string) $request->request('query')) !== '' || $request->request('akID') || $request->request('month')) {
                $this->do_search();
            }
        }
    }

    public function save($data)
    {
        $data += array(
            'title' => '',
            'buttonText' => '',
            'baseSearchPath' => '',
            'searchUnderCID' => 0,
            'postTo_cID' => 0,
            'externalTarget' => 0,
            'resultsURL' => '',
        );
        $args = array();
        $args['title'] = $data['title'];
        $args['buttonText'] = $data['buttonText'];
        $args['baseSearchPath'] = $data['baseSearchPath'];
        if ($args['baseSearchPath'] == 'OTHER' && intval($data['searchUnderCID']) > 0) {
            $customPathC = Page::getByID(intval($data['searchUnderCID']));
            if (!$customPathC) {
                $args['baseSearchPath'] = '';
            } else {
                $args['baseSearchPath'] = $customPathC->getCollectionPath();
            }
        }
        if (trim($args['baseSearchPath']) == '/' || strlen(trim($args['baseSearchPath'])) == 0) {
            $args['baseSearchPath'] = '';
        }

        if (intval($data['postTo_cID']) > 0) {
            $args['postTo_cID'] = intval($data['postTo_cID']);
        } else {
            $args['postTo_cID'] = '';
        }

        $args['resultsURL'] = ($data['externalTarget'] == 1 && strlen($data['resultsURL']) > 0) ? trim($data['resultsURL']) : '';
        parent::save($args);
    }

    public $reservedParams = array('page=', 'query=', 'search_paths[]=', 'submit=', 'search_paths%5B%5D=');

    public function do_search()
    {
        $request = Request::getInstance();

        $query = (string) $request->request('query');
        
        $ipl = new PageList();
        $aksearch = false;
        $akIDs = $request->request('akID');
        if (is_array($akIDs)) {
            foreach ($akIDs as $akID => $req) {
                $fak = CollectionAttributeKey::getByID($akID);
                if (is_object($fak)) {
                    $type = $fak->getAttributeType();
                    $cnt = $type->getController();
                    $cnt->setAttributeKey($fak);
                    $cnt->searchForm($ipl);
                    $aksearch = true;
                }
            }
        }

        if ($request->request('month') !== null && $request->request('year') !== null) {
            $year = @intval($request->request('year'));
            $month = abs(@intval($request->request('month')));
            if (strlen(abs($year)) < 4) {
                $year = (($year < 0) ? '-' : '') . str_pad(abs($year), 4, '0', STR_PAD_LEFT);
            }
            if ($month < 12) {
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            }
            $daysInMonth = date('t', strtotime("$year-$month-01"));
            $dh = Core::make('helper/date');
            /* @var $dh \Concrete\Core\Localization\Service\Date */
            $start = $dh->toDB("$year-$month-01 00:00:00", 'user');
            $end = $dh->toDB("$year-$month-$daysInMonth 23:59:59", 'user');
            $ipl->filterByPublicDate($start, '>=');
            $ipl->filterByPublicDate($end, '<=');
            $aksearch = true;
        }

        if ($query === '' && $aksearch === false) {
            return false;
        }

        if ($query !== '') {
            $ipl->filterByKeywords($query);
        }

        $search_paths = $request->request('search_paths');
        if (is_array($search_paths)) {
            foreach ($search_paths as $path) {
                if ($path === '') {
                    continue;
                }
                $ipl->filterByPath($path);
            }
        } elseif ($this->baseSearchPath != '') {
            $ipl->filterByPath($this->baseSearchPath);
        }

        $cak = CollectionKey::getByHandle('exclude_search_index');
        if (is_object($cak)) {
            $ipl->filterByExcludeSearchIndex(false);
        }

        $pagination = $ipl->getPagination();
        $results = $pagination->getCurrentPageResults();

        $this->set('query', $query);
        $this->set('results', $results);
        $this->set('do_search', true);
        $this->set('searchList', $ipl);
        $this->set('pagination', $pagination);
    }
}
