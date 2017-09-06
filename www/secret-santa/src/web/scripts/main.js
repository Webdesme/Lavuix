$(document).ready(function() {
    formInit();
    parallaxInit();
    //initPreloader();
});

$(window).load(function () {
    hidePreloader();
});

function formInit() {
    $("form").on('submit', function () {
        $('input[type=submit]').prop('disabled', true);
    });
}

function parallaxInit() {
    var scene = $("#scene")[0];
    return new Parallax(scene);
}

function setHomeInputs() {
    var max_fields = 35;
    var start_count = 3;
    var wrapper = $("#home-form .emails-group");
    var toogleBtn = function () {
        var btn = $(wrapper).find('.input.opacity');
        var count = $(wrapper).find('.input').not('.opacity').size();
        (count >= max_fields) ? btn.hide() : btn.show();
    }

    $(wrapper).append('<div class="input opacity"><input type="email" readonly placeholder="Введите адрес"><div class="del-no"></div></div>');

    for (var i = 0; i < start_count; i++) {
        $(wrapper).find('.input.opacity').before('<div class="input"><input type="email" placeholder="Введите адрес" required name="emails[]"><div class="del-no"></div></div>');
    }

    $(wrapper).on('focus', '.input.opacity', function (e) {
        e.preventDefault();
        var count = $(wrapper).find('.input').not('.opacity').size();
        if (count < max_fields) {
            $(wrapper).find('.input.opacity').before('<div class="input"><input type="email" placeholder="Введите адрес"  name="emails[]"><div class="del"></div></div>');
            $(wrapper).find('.input').not('.opacity').last().find('input[type=email]').trigger('focus');
            toogleBtn();
        }
    });

    $(wrapper).on("click",".del", function(e) {
        e.preventDefault();
        $(this).parent('div.input').remove();
        toogleBtn();
        return false;
    });
}

function setResultInputs() {
    var max_fields = 35;
    var start_count = 3;
    var wrapper = $("#result-form .checkwords-group");
    var toogleBtn = function () {
        var btn = $(wrapper).find('.checkword.opacity');
        var count = $(wrapper).find('.checkword').not('.opacity').size();
        (count >= max_fields) ? btn.hide() : btn.show();
    }

    $(wrapper).append('<input type="text" class="checkword opacity" readonly />');

    for (var i = 0; i < start_count; i++) {
        $(wrapper).find('.checkword.opacity').before('<input type="text" class="checkword" required name="checkwords[]" />');
    }

    $(wrapper).on('focus', '.checkword.opacity', function (e) {
        e.preventDefault();
        var count = $(wrapper).find('.checkword').not('.opacity').size();
        if (count < max_fields) {
            $(wrapper).find('.checkword.opacity').before('<input type="text" class="checkword" name="checkwords[]" />');
            $(wrapper).find('.checkword').not('.opacity').last().trigger('focus');
            toogleBtn();
        }
    });
}

function initPreloader() {
    $("#preloader").show();
}

function hidePreloader() {
    var path_arr = ['', 'web', 'home', 'result'];
    if ($.inArray(window.location.pathname.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, ""), path_arr) >= 0) {
        setTimeout(function() {
            $("#preloader").fadeOut('slow', function() {});
        }, 1500);
    }
    else {
        $("#preloader").hide();
    }
}