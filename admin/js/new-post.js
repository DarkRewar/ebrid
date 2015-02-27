var scripts2load = ["js/mod/add_category_modal.js"];
loadScripts(scripts2load);

function checkParent(id){
    $('input[value="'+id+'"]').prop('checked', true);
    if($('input[value="'+id+'"]').data('parent') > 0)
        checkParent($('input[value="'+id+'"]').data('parent'));
}

function checkSons(id){
    $('input[data-parent="'+id+'"]').prop('checked', false);
    if($('input[data-parent="'+id+'"]').data('parent') > 0)
        checkSons($('input[data-parent="'+id+'"]').val());
}

$(document).ready(function(){
    $('input[type="checkbox"]').on('change', function(){
        if($(this).prop('checked')){
            checkParent($(this).data('parent'));
        }else{
            checkSons($(this).val());
        }
    });

    $('#cat-send').click(function(event){
        event.preventDefault();
        $('#add_new_category').addCategory();
    });
});