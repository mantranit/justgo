/**
 * Created by ManTran on 6/17/2015.
 */
$(function(){
    var pageBuilder = $('.page-builder');

    var url = pageBuilder.data('href');
    $.get(url, function(html){
        pageBuilder.append(html);

        $('.modal-button-group .cancel').on('click', function(){
            $('#' + $(this).data('modalId')).foundation('reveal', 'close');
        });
        $('.modal-button-group .save.pb-row-btn').on('click', function(){
            var that = $(this),
                values = that.parent().parent().serialize(),
                href = $('#' + that.data('modalId')).data('href'),
                id = $('#' + that.data('modalId')).data('id');

            $.post(href, values, function(html){
                $('#' + that.data('modalId')).foundation('reveal', 'close');
                $('#element' + id).html(html);
            });
        });
        $('.modal-button-group .save.pb-element-btn').on('click', function(){
            var that = $(this),
                values = that.parent().parent().serialize(),
                href = $('#' + that.data('modalId')).data('href'),
                itemId = $('#' + that.data('modalId')).data('itemId');

            $.post(href + '&' + values, function(html){
                $('#' + that.data('modalId')).foundation('reveal', 'close');
                $('#column-content-' + itemId).append(html);
            });
        });
    });

    pageBuilder
        .on('click', '.add-e-pb', function(){
            var that = $(this),
                url = that.attr('href');
            $.get(url, function(html){
                that.parent().parent().append(html);
            });
            return false;
        })

        /* modal */
        .on('click', '.open-modal.edit-row', function(e){
            e.preventDefault();
            var that = $(this);

            var modal = $('#' + that.data('revealId'));
            modal.data('href', that.data('urlPost'));
            modal.data('id', that.data('id'));

            $.get(that.data('urlGet'), function(data){
                var json = JSON.parse(JSON.parse(data));

                modal.find('[name="container"]').val(json.container);
                modal.find('[name="columnsType"]').val(json.columnsType);
                modal.find('[name="extraClass"]').val(json.extraClass);
            });

            modal.foundation('reveal', 'open');
        })
        .on('click', '.open-modal.add-element', function(e){
            e.preventDefault();
            var that = $(this);

            var modal = $('#' + that.data('revealId'));
            modal.data('href', that.data('urlPost'));
            modal.data('itemId', that.data('itemId'));

            modal.find('[name="parent_id"]').val(that.data('id'));

            modal.foundation('reveal', 'open');
        })

        /* row */
        .on('click', '.add-e-row', function(){
            var that = $(this),
                url = that.attr('href');
            $.get(url, function(html){
                that.parent().parent().append(html);
            });
            return false;
        })
        .on('click', '.active-e-row', function(){
            var that = $(this),
                url = that.attr('href');
            $.post(url, function(response){
                var json = JSON.parse(response);
                if(json.status) {
                    that.removeClass('fa-toggle-on').addClass('fa-toggle-off');
                }
                else {
                    that.removeClass('fa-toggle-off').addClass('fa-toggle-on');
                }
            });
            return false;
        })
        .on('click', '.delete-e-row', function(){
            var that = $(this),
                url = that.attr('href');
            $.post(url, function(response){
                var json = JSON.parse(response);
                if(json.status) {
                    that.parent().parent().hide();
                }
            });
            return false;
        });
});