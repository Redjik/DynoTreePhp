<?php

/**
 * @property $nodeDropCallback string @see DynaTree::$defaultDropCallback
 * @property $nodeOnActiveCallback
 */
class DynaNode extends CComponent
{
    /**
     * @var string node Name
     */
    public $title;

    /**
     * @var bool rendered as Folder
     */
    public $isFolder = false;

    /**
     * @var bool Ajax Children
     */
    public $isLazy = false;

    /**
     * @var array DynaNode[]
     */
    public $children = array();

    /**
     * @var bool is node draggable
     */
    public $draggable = false;

    /**
     * @var bool whether we can drop inside the node
     */
    public $dropable = false;

    /**
     * @var string node link
     */
    public $href = false;

    /**
     * @var string id of the contextMenu opened with the right click on node
     */
    public $contextMenuId;

    /**
     * @var DynaMenu
     */
    protected $contextMenu;

    public function __construct($title = '')
    {
        $this->title = $title;
    }

    /**
     * js function (node, sourceNode, hitMode, ui, draggable)
     * @param $string
     * @return CJavaScriptExpression
     */
    public function setNodeDropCallback($string)
    {
        return $this->nodeDropCallback = new CJavaScriptExpression($string);
    }

    /**
     * js function (node)
     * @param $string
     * @return CJavaScriptExpression
     */
    public function setNodeOnActiveCallback($string)
    {
        return $this->nodeOnActiveCallback = new CJavaScriptExpression($string);
    }


    /**
     * Add child node to the node
     * @param DynaNode $node
     * @return DynaNode
     */
    public function addNode(DynaNode $node)
    {
        $this->children[] = $node;
        return $this;
    }

    /**
     * @param DynaMenu $dynaMenu
     */
    public function addMenu(DynaMenu $dynaMenu)
    {
        $this->contextMenuId = $dynaMenu->menuIdentifier;
        $this->contextMenu = $dynaMenu;
    }

    /**
     * @return DynaMenu
     */
    public function getMenu()
    {
        return $this->contextMenu;
    }

    /**
     * If this node has contextMenu
     * @return bool
     */
    public function hasMenu()
    {
        return !is_null($this->contextMenuId);
    }

    /**
     * if this node Has children
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * getter for node children
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
}
