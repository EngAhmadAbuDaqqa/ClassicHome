$(function () {
    'user strict';
    //dashboard
    $('.toggle-info').click(function() {
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
        if ($(this).hasClass('selected')) {
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        } else {
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }

    });

      // trigger the selectBoxIt
    $("select").selectBoxIt({
        autoWidth: false
    });


    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // convert password field to text filed on hover 
    var passFiled = $('.password');
    $('.show-pass').hover(function () {
        passFiled.attr('type', 'text');
    }, function () {
        passFiled.attr('type', 'password');

    });

    //confirm massage on button delete
    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });

    // category view option 
    $('.cat h3').click(function () {
        $(this).next('.full-view').fadeToggle(200);
    });

    $('.option span').click(function (){
        
        $(this).addClass('active').siblings('span').removeClass('active');
        
        if ($(this).data('view') === 'full') {

            $('.cat .full-view').fadeIn(200);

        } else {
            $('.cat .full-view').fadeOut(200); 
        }
    });
    //show delete button on child cats
    $('.child-link').hover(function () {
        $(this).find('.show-delete').fadeIn(300);
    }, function () {
        $(this).find('.show-delete').fadeOut(300);
    });

});
