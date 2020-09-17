$('.btn_close').click(function () {
    $('.right_menu_container').css('left', '3000px');
    $('#myOverlay').fadeOut(297);
    // $('body').css('overflow','auto');
});

$('.open_right_menu').click(function () {
    $('.right_menu_container').css('left', '0px');
    $('#myOverlay').fadeIn(297);
    // $('body').css('overflow','hidden');
});

(function($) {
    $.fn.menumaker = function(options) {

        var cssmenu = $(this), settings = $.extend({
            title: "Menu",
            format: "dropdown",
            sticky: false
        }, options);

        return this.each(function() {
            cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
            $(this).find("#menu-button").on('click', function(){
                $(this).toggleClass('menu-opened');
                var mainmenu = $(this).next('ul');
                if (mainmenu.hasClass('open')) {
                    mainmenu.hide().removeClass('open');
                }
                else {
                    mainmenu.show().addClass('open');
                    if (settings.format === "dropdown") {
                        mainmenu.find('ul').show();
                    }
                }
            });

            cssmenu.find('li ul').parent().addClass('has-sub');

            multiTg = function() {
                cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
                cssmenu.find('.submenu-button').on('click', function() {
                    $(this).toggleClass('submenu-opened');
                    if ($(this).siblings('ul').hasClass('open')) {
                        $(this).siblings('ul').removeClass('open').hide();
                    }
                    else {
                        $(this).siblings('ul').addClass('open').show();
                    }
                });
            };

            if (settings.format === 'multitoggle') multiTg();
            else cssmenu.addClass('dropdown');

            if (settings.sticky === true) cssmenu.css('position', 'fixed');

            resizeFix = function() {
                if ($( window ).width() > 768) {
                    cssmenu.find('ul').show();
                }

                if ($(window).width() <= 768) {
                    cssmenu.find('ul').hide().removeClass('open');
                }
            };
            resizeFix();
            return $(window).on('resize', resizeFix);

        });
    };
})(jQuery);

(function($){
    $(document).ready(function(){

        $("#cssmenu").menumaker({
            title: "Поиск",
            format: "multitoggle"
        });

    });
})(jQuery);

(function(){
    jQuery("input[name=proftype]").change(function() {
        jQuery('#profstatus').submit();
    })
    jQuery("input[name=profstatus]").change(function() {
        jQuery('#profstatus').submit();
    })

})();
$(document).ready(function () {
    $("#prfupdate").on('click',function (e) {
        setFoto();
        if (!$('#profupdate').parsley('validate')) {
            e.preventDefault();
        }else {
            $('#profupdate').submit();
        }
    });
})
//iCheck[components] validate
$('input').on('ifChanged', function (event) {
    $(event.target).parsley('validate');
});
$('.fileinput-preview').change(function () {
    console.log('trr');
})

function setFoto() {
    var image = $('.fileinput-exists').children('img');
    if(image.length) {
        $('#avatar').val(image[0].src);
    }
}
