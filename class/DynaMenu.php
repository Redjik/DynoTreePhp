<?php

class DynaMenu extends CComponent
{
    public $menuIdentifier;

    public $items = array();

    public function __construct($contextIdentifier = 'jq_menu')
    {
        $this->menuIdentifier = $contextIdentifier;
    }

    public function addAction(DynaMenuAction $action)
    {
        $this->items[] = $action;
    }

    public function addSeparator()
    {
        $this->items['sep1'] = '---------';
    }
}
