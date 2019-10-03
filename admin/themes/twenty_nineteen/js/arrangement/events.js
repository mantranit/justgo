/**
 * Created by ManTran on 6/24/2015.
 */
$(function(){
    $('#arrangement-form').on('submit', function(){
        var dataString = [];
        $('#arrangementSelected li').each(function(i, e){
            dataString.push($(this).data('id'));
        });
        $('#arrangementProduct').val(dataString.toString());
    });

    var support = $('.support-config');
    if(support.length > 0) {
        support.sortable();
        $('.add-support').on('click', function () {
            var children = support.find('li');
            var index = children.length;
            support.append(
                '<li class="contact contact-item-' + index + '" data-index="' + index + '" draggable="true">' +
                '<div class="row">' +
                '<div class="form-group columns small-6">' +
                '<label class="control-label">Type</label>' +
                '<select class="form-control" name="Support[' + index + '][type]">' +
                '<option value="yahoo" selected="">Yahoo</option>' +
                '<option value="skype">Skype</option>' +
                '</select>' +
                '</div>' +
                '<div class="form-group columns small-6">' +
                '<label class="control-label">Name</label>' +
                '<input type="text" class="form-control" name="Support[' + index + '][name]">' +
                '</div>' +
                '<div class="form-group columns small-6">' +
                '<label class="control-label">Nickname</label>' +
                '<input type="text" class="form-control" name="Support[' + index + '][nickname]">' +
                '</div>' +
                '<div class="form-group columns small-5">' +
                '<label class="control-label">Phone</label>' +
                '<input type="text" class="form-control" name="Support[' + index + '][phone]">' +
                '</div>' +
                '<div class="form-group columns small-1">' +
                '<a class="remove-suport">x</a>' +
                '</div>' +
                '</div>' +
                '</li>'
            );
            support.sortable('destroy');
            support.sortable();
        });
        support.on('click', '.remove-suport', function () {
            $(this).parents('.contact').remove();
        });
    }
});