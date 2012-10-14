<?php

/**
 * @property $defaultDropCallback string
 */
class DynaTree extends CComponent
{
    /**
     * @var DynaNode[]
     */
    protected $nodes = array();

    /**
     * @var array
     */
    protected $menus = array();

    protected $treeIdentifier;

    /**
     * js function can have params:node, sourceNode, hitMode, ui, draggable
     * @var $defaultDropCallback string
     */
    protected $defaultDropCallback = null;

    public function __construct($treeIdentifier = 'tree')
    {
        $this->treeIdentifier = $treeIdentifier;
    }

    public function setDefaultDropCallback($string)
    {
        return $this->defaultDropCallback = new CJavaScriptExpression($string);
    }

    /**
     * @param DynaNode $node
     * @return DynaTree
     */
    public function addNode(DynaNode $node)
    {
        $this->nodes[]=$node;
        return $this;
    }

    /**
     * renders tree outputs
     */
    public function renderTree()
    {
        echo '<div id="'.$this->treeIdentifier.'"></div>';
        $this->renderVars();
    }

    /**
     * vars defining context menus and nodes
     */
    protected function renderVars()
    {
        $nodes = $this->prepareNodes();
        $menus = $this->prepareMenus();
        $defaultDropCallback = $this->prepareDefaultDropCallback();
        echo "
        <script type='text/javascript'>
            var DynoTrees = this.DynoTrees || {};
            DynoTrees.{$this->treeIdentifier} = {
                    id:'{$this->treeIdentifier}',
                    nodes:{$nodes},
                    menus:{$menus},
                    defaultDropCallback:{$defaultDropCallback}
                };
        </script>
        ";
    }

    /**
     * collects all contextMenues from nodes into $menus[]
     * with MenuIdentifier as key
     * @param null|DynaNode[] $nodes
     */
    protected function parseMenus($nodes = null)
    {
        if (!$nodes)
            $nodes = $this->nodes;

        if ($nodes)
        {
            foreach ($this->nodes as $node)
            {
                if ($node->hasMenu())
                    $this->menus[$node->contextMenuId]=$node->getMenu();

                if ($node->hasChildren())
                    $this->parseMenus($node->getChildren());
            }
        }
    }

    /**
     * @return string json encoded string of all nodes
     * needed for vars init output
     */
    protected function prepareNodes()
    {
        return CJavaScript::encode($this->nodes);
    }

    /**
     * @return string json encoded string of all context menus
     * needed for vars init output
     */
    protected function prepareMenus()
    {
        $this->parseMenus();
        return CJavaScript::encode($this->menus);
    }

    protected function prepareDefaultDropCallback()
    {
        return CJavaScript::encode($this->defaultDropCallback);
    }


}
