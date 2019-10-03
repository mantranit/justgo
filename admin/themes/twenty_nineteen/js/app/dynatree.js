/**
 * Created by ManTran on 6/23/2015.
 */
$(function(){
    $("#tree2").dynatree({
        checkbox: true,
        selectMode: 2,
        expand: true,
        debugLevel: 0,
        children: treeData,
        onSelect: function(select, node) {
            // Display list of selected nodes
            var selNodes = node.tree.getSelectedNodes();
            // convert to title/key array
            var selKeys = $.map(selNodes, function(node){
                return node.data.key;
            });
            $("#echoSelection2").val(selKeys.join(", "));
        },
        onClick: function(node, event) {
            // We should not toggle, if target was "checkbox", because this
            // would result in double-toggle (i.e. no toggle)
            if( node.getEventTargetType(event) === "title" ) {
                node.toggleSelect();
            }
        },
        onKeydown: function(node, event) {
            if( event.which === 32 ) {
                node.toggleSelect();
                return false;
            }
        },
        onCreate: function(node) {
            node.expand(true);
        },
        // The following options are only required, if we have more than one tree on one page:
        cookieId: "dynatree-Cb2",
        idPrefix: "dynatree-Cb2-"
    });
});