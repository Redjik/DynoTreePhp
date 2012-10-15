for (tree in DynoTrees)
{
    //treeObj has
    //1) id of the tree
    //2) nodes
    //3) contextMenus objects
    //4) defaultDropCallback
    treeObj = DynoTrees[tree];

    $('#'+treeObj.id).dynatree({
        debugLevel : false,
        persist : true,
        children : treeObj.nodes,
        contextMenus:treeObj.menus,
        defaultDropCallback:treeObj.defaultDropCallback,
        onActivate: function(node) {

            if (node.contextInit)
            {
                return false;
            }

            if (node.data.nodeOnActiveCallback)
            {
                node.data.nodeOnActiveCallback();
            }
            else if( node.data.href )
            {
                window.open(node.data.href, node.data.target);
            }
        },
        dnd: {
            preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
            autoExpandMS:300,
            onDragStart: function(node) {
                /** This function MUST be defined to enable dragging for the tree.
                 *  Return false to cancel dragging of node.
                 */
                return node.data.draggable;
            },
            onDragEnter: function(node, sourceNode) {
                /** sourceNode may be null for non-dynatree droppables.
                 *  Return false to disallow dropping on node. In this case
                 *  onDragOver and onDragLeave are not called.
                 *  Return 'over', 'before, or 'after' to force a hitMode.
                 *  Return ['before', 'after'] to restrict available hitModes.
                 *  Any other return value will calc the hitMode from the cursor position.
                 */

                if (node.data.dropable)
                    return ['over', 'before' ,'after'];
                else
                    return ["before", "after"];

            },
            onDrop: function(node, sourceNode, hitMode, ui, draggable) {
                /** This function MUST be defined to enable dropping of items on
                 *  the tree.
                 */

                parentNode = sourceNode.getParent();

                sourceNode.move(node, hitMode);

                if (hitMode === 'over'){
                    node.data.isFolder = true;
                    node.expand(true);
                    node.render();
                }

                if (!parentNode.hasChildren()){
                    parentNode.data.isFolder = false;
                    parentNode.render();
                }

                if (node.data.nodeDropCallback)
                {
                    node.data.nodeDropCallback(node, sourceNode, hitMode, ui, draggable);
                }
                else if (node.tree.options.defaultDropCallback)
                {
                    node.tree.options.defaultDropCallback(node, sourceNode, hitMode, ui, draggable);
                }
            }
        }
    });
}

$.contextMenu({
    selector: 'a.dynatree-title',
    build: function($trigger, e) {
        // this callback is executed every time the menu is to be shown
        // its results are destroyed every time the menu is hidden
        // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
        var node = $.ui.dynatree.getNode($trigger);

        node.contextInit = true;
        node.activate();
        node.contextInit = false;

        menuId = node.data.contextMenuId;

        if (menuId)
        {
            menu = node.tree.options.contextMenus[menuId];
            if (menu && menu.items.length > 0)
                return menu;
        }
        return false;

    }
});
