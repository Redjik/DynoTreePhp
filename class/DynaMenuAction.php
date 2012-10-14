<?php

/**
 * @property $callback string
 * @property $items array
 */
class DynaMenuAction extends CComponent
{

    public $name;

    public $icon;

    public function __construct($name = 'test')
    {
        $this->name = $name;
    }

    /**
     * Callback for menu action
     * Example: {
     *      callback: function(key, opt){
     *          alert("Clicked on " + key + " on element " + opt.$trigger.attr("id"));
     *      }
     * }
     *
     * so our code should be
     *
     * function(key, opt){
     *      var node = $.ui.dynatree.getNode(opt.$trigger);
     *      alert("Clicked on " + key + " on element " + node.data.title);
     * }
     *
     * @param string $code
     * @return void
     */
    public function setCallback($code)
    {
        $this->callback = new CJavaScriptExpression($code);
    }

    /**
     * items setter
     * @param DynaMenuAction $action
     */
    public function addAction(DynaMenuAction $action)
    {
        if (!isset($this->items))
            $this->items = array();

        $this->items[] = $action;
    }



}
