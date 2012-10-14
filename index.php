<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <title>Dynatree - Example</title>

    <script src="/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/jquery/jquery.cookie.js" type="text/javascript"></script>

    <link href="/class/js/skin/ui.dynatree.css" rel="stylesheet" type="text/css" id="skinSheet">
    <script src="/class/js/jquery.dynatree.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="/class/js/jq.context/jquery.contextMenu.css">
    <script type="text/javascript" src="/class/js/jq.context/jquery.contextMenu.js"></script>

</head>

<body class="example">

<?php
include_once('class/Component.php');
include_once('class/DynaTree.php');
include_once('class/DynaNode.php');
include_once('class/DynaMenu.php');
include_once('class/DynaMenuAction.php');
include_once('class/helpers/CJavaScriptExpression.php');
include_once('class/helpers/CJavaScript.php');


$tree = new DynaTree('tree1');
$tree->defaultDropCallback ='function(node, sourceNode, hitMode, ui, draggable){console.log(node)}';
$menu = new DynaMenu('1stMenu');
$action = new DynaMenuAction('Alert');
$action->icon = 'edit';
$action->callback = 'function(){alert("hello world")}';
$menu->addAction($action);
for ($i = 0;$i<10;$i++)
{
    $node = new DynaNode('Узел - '.$i);
    $node->draggable = true;
    $node->dropable = true;
    $node->nodeDropCallback = 'function(node, sourceNode, hitMode, ui, draggable){console.log("zzz")}';
    $node->addMenu($menu);
    $tree->addNode($node);
}
$tree->renderTree();
?>
<script type='text/javascript' src='/class/js/treeinit.js'></script>
</body>
</html>


