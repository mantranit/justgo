$(function(){
    $('.connected').sortable({
        connectWith: '.connected'
    });
    $('#action-form').on('submit', function(){
        var stringRelated = '';
        $('.related .connected li').each(function(index, element){
            if(index > 0) {
                stringRelated += ',';
            }
            stringRelated += $(this).data('id');
        });
        $('#relatedProduct').val(stringRelated);

        var images = $('input[name="Product[image_id]"]');
        if(images.length > 0) {
            var flag = true;
            images.each(function () {
                if ($(this).prop('checked')) {
                    flag = false;
                    return;
                }
            });
            if (flag) {
                $(images.get(0)).prop('checked', 'checked');
            }
        }
    });
});

(function ($) {
    // custom css expression for a case-insensitive contains()
    jQuery.expr[':'].Contains = function(a,i,m){
        return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
    };

    function listFilter(input, list) { // header is any element, list is an unordered list
        $(input)
            .change( function () {
                var filter = $(this).val();
                if(filter) {
                    // this finds all links in a list that contain the input,
                    // and hide the ones not containing the input while showing the ones that do
                    $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
                    $(list).find("a:Contains(" + filter + ")").parent().slideDown();
                } else {
                    $(list).find("li").slideDown();
                }
                return false;
            })
            .keyup( function () {
                // fire the above change event after every letter
                $(this).change();
            });
    }


    //ondomready
    $(function () {
        listFilter($(".search .search-box input"), $(".search .list"));
    });
}(jQuery));