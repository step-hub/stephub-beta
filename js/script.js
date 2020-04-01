$(function(){
    $(".myPopover").popover();
});

$(document).ready(function(){
    $('#register').prop('disabled', true);

    $('#remember').click(function(){
        if($(this).is(':checked'))
        {
            $('#register').prop('disabled', false);
        }
        else
        {
            $('#register').prop('disabled', true);
        }
    });
});