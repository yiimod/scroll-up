<?php

/**
 * Class IasPager
 */
class ScrollUpPager extends CLinkPager
{

    /**
     * @var
     */
    public $listViewId;
    /**
     * @var string
     */
    public $rowSelector = '.row';
    /**
     * @var string
     */
    public $itemsSelector = ' > .items';
    /**
     * @var string
     */
    public $nextSelector = '.next:not(.disabled):not(.hidden) a';
    /**
     * @var string
     */
    public $pagerSelector = '.pager';
    /**
     * @var array
     */
    public $options = array();
    /**
     * @var array
     */
    public $linkOptions = array();
    /**
     * @var
     */
    private $baseUrl;

    /**
     *
     */
    public function init()
    {

        parent::init();


        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $assets = dirname(__FILE__) . '/assets/js';
        $this->baseUrl = Yii::app()->assetManager->publish($assets);
        $cs->registerScriptFile($this->baseUrl . '/jquery.iasUp.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->baseUrl . '/callbacks.js', CClientScript::POS_END);
        return;
    }

    /**
     *
     */
    public function run()
    {
        $js = "var iasUp = $.iasUp(" .
            CJavaScript::encode(
                CMap::mergeArray($this->options, array(
                    'container' => '#' . $this->listViewId . '' . $this->itemsSelector,
                    'scrollContainer' => "#" . $this->listViewId . "",
                    'item' => $this->rowSelector,
                    'pagination' => '#' . $this->listViewId . ' ' . $this->pagerSelector,
                    'next' => '#' . $this->listViewId . ' ' . $this->nextSelector,
                ))) . ");
                ";
        $cs = Yii::app()->clientScript;
        $cs->registerScript(__CLASS__ . $this->id, $js, CClientScript::POS_LOAD);


        $buttons = $this->createPageButtons();
        echo $this->header; // if any
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo $this->footer; // if any
    }

    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected)
            $class .= ' ' . ($hidden ? 'disabled' : 'active');

        return CHtml::tag('li', array('class' => $class), CHtml::link($label, $this->createPageUrl($page), $this->linkOptions));
    }

}
