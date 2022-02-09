<?php  defined('C5_EXECUTE') or die("Access Denied."); 

?>

<div class="ccm-block-topic-list-wrapper">

    <div class="ccm-block-topic-list-header">
        <h5><?php echo h($title); ?></h5>
    </div>
    
    <form name="topics-sel" id="topics-sel" method="post">
        <input type="hidden" name="form-type" value="topic select">
    <?php
    if ($mode == 'S' && is_object($tree)) {
        $node = $tree->getRootTreeNodeObject();
        $node->populateChildren();
        if (is_object($node)) {
            if (!isset($selectedTopicID)) {
                $selectedTopicID = null;
            }
            $walk = function ($node) use (&$walk, &$view, $selectedTopicID) {
                ?><ul class="ccm-block-topic-list-list"><?php
                $session = Core::make('app')->make('session');
                $session_topicFilters = unserialize($session->get('topicFilters'));

                foreach ($node->getChildNodes() as $topic) {
                    if ($topic instanceof \Concrete\Core\Tree\Node\Type\Category) {
                        ?><li><input type="checkbox" name="topicFilter[<?php echo $topic->getTreeNodeID(); ?>]" value="<?php echo $topic->getTreeNodeID(); ?>" onclick="$(this).closest('form').submit();" <?php if($session_topicFilters[$topic->getTreeNodeID()]){ echo 'checked="checked"';}?> > <?php echo $topic->getTreeNodeDisplayName(); ?></li>
                        <?php
                    } else {
                        ?><li><input type="checkbox" name="topicFilter[<?php echo $topic->getTreeNodeID(); ?>]" value="<?php echo $topic->getTreeNodeID(); ?>" onclick="$(this).closest('form').submit();" <?php if($session_topicFilters[$topic->getTreeNodeID()]){ echo 'checked="checked"';}?> > <a href="<?php echo $view->controller->getTopicLink($topic); ?>" <?php
                        if (isset($selectedTopicID) && $selectedTopicID == $topic->getTreeNodeID()) {
                            ?> class="ccm-block-topic-list-topic-selected"<?php
                        }
                        ?>><?php echo $topic->getTreeNodeDisplayName(); ?></a></li><?php
                    }
                    if (count($topic->getChildNodes())) {
                        $walk($topic);
                    } ?>
                    </li>
                    <?php
                }
                ?></ul><?php
            };
            $walk($node);
        }
    }

    if ($mode == 'P') {
        if (isset($topics) && count($topics)) {
            $session = Core::make('app')->make('session');
            $session_topicFilters = unserialize($session->get('topicFilters'));
            ?><ul class="ccm-block-topic-list-page-topics"><?php
            foreach ($topics as $topic) {
                ?><li><input type="checkbox" name="topicFilter[<?php echo $topic->getTreeNodeID(); ?>]" value="<?php echo $topic->getTreeNodeID(); ?>" onclick="$(this).closest('form').submit();" <?php if($session_topicFilters[$topic->getTreeNodeID()]){ echo 'checked="checked"';}?> > <a href="<?php echo $view->controller->getTopicLink($topic); ?>"><?php echo $topic->getTreeNodeDisplayName(); ?></a></li><?php
            }
            ?></ul><?php
        } else {
            echo t('No topics.');
        }
    }
    ?>
    
    </form>
</div>
