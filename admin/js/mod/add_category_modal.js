if (typeof jQuery !== 'undefined') {
    $.fn.extend({
        addCategory: function(){
            var dis = $(this);
            var datas = $(this).serialize();

            if($('#box-msg-cat').length > 0) $('#box-msg-cat').remove();

            dis.prepend(
                $('<div />')
                    .attr('id','box-msg-cat')
                    .addClass('message info')
                    .html('Sending...')
            );

            $.ajax({
                url: getPathAJAX(),
                type: 'POST',
                data: datas+"&requested=addCategory",
                dataType: 'json',
                async: 'false',
                success: function(json) {
                    $('#box-msg-cat')
                        .removeClass('info')
                        .addClass(json.e)
                        .html(json.message)
                        .append(
                            $('<a />')
                                .addClass('close')
                                .html("&times")
                        )
                },
                error: function(xhr, status, error) {
                    $('#box-msg-cat')
                        .removeClass('info')
                        .addClass('error')
                        .html('['+status+'] '+error)
                        .append(
                            $('<a />')
                                .addClass('close')
                                .html("&times")
                        )
                },
                404: function(){
                    $('#box-msg-cat')
                        .removeClass('info')
                        .addClass('error')
                        .html(getPathAJAX()+' is required but it dosen\'t exist.')
                        .append(
                            $('<a />')
                                .addClass('close')
                                .html("&times")
                        )
                }
            });
        }
    });
}