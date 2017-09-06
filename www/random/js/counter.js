$(document).ready(function() {
    /* Настройки ajax */
    $.ajaxSetup({
        type: 'POST',
        url: 'ajax.php',
        async: true,
        dataType: 'json'
    });

    /* Ввод только чисел */
    function enterOnlyNumbers(input, event)
    {
        var isMinus = ((event.keyCode == 109) || (event.keyCode == 189)) ? true : false;

        if (!event.shiftKey) {

            if (isMinus && !input.val()) {
                return true;
            } else {
                return (((event.keyCode > 47) && (event.keyCode < 58))
                || ((event.keyCode > 95) && (event.keyCode < 106))
                || ((event.keyCode > 111) && (event.keyCode < 124))
                || (event.keyCode == 8) || (event.keyCode == 46)
                || (event.keyCode == 37) || (event.keyCode == 39)
                && !isMinus) ? true : false;
            }
        } else {
            return false;
        }
    }

    /* Преобразование слова рядом с цифрой */
    function wordCount($n, $words)
    {
        var $x = ($xx = $n%100)%10;
        return $words[((($xx > 10) && ($xx < 15)) || !$x || (($x > 4) && ($x < 10))) ? 2 : (($x == 1) ? 0 : 1)];
    }

    /* Слайдер */
    $('#slider').slider({
        min: $('#slider').data('min'),
        max: $('#slider').data('max'),
        value: $('#slider').data('val'),
        range: 'min',
        slide: function(event, ui) {
            var words = $('#slider-val').data('words').split(',');
            $('#slider-val').text(ui.value + ' ' + wordCount(ui.value, words));

            if (ui.value > 1) {
                $('#unique label').fadeIn(200);
            } else {
                $('#unique label').fadeOut(200);
            }
        }
    });

    /* Случайная страница */
    $('#button.main').click(function() {
        var pageList = {
            1: '/number/',
            2: '/joke/',
            3: '/saying/',
            4: '/question/',
            5: '/ticket/',
            6: '/password/',
            7: '/ask/',
            8: '/fact/'
        };
        var page = Math.floor(8*Math.random()) + 1;

        location = pageList[page];
    });

    /* Ввод диапазона чисел */
    $('#number-start, #number-end').keydown(function(e) {
        return enterOnlyNumbers($(this), e);
    });

    /* Последовательность случайных чисел */
    $('#button.number').click(function() {
        var start = $('#number-start').val();
        var end = $('#number-end').val();
        var cnt = $("#slider").slider('value');
        var uniq = $('#number-unique').attr('checked');
        var tz = new Date().getTimezoneOffset();

        var curCont = $('#number');
        var saveDlg = $('#save');

        $.ajax({
            data: {'get_number': true, 'cnt': cnt, 'start': start, 'end': end, 'uniq': uniq, 'tz': tz},
            success: function(data) {
                if (!data.error) {
                    if (1 === cnt) {
                        $('#caption').text('Случайное число:');
                        if (curCont.is('.multi')) {
                            curCont.html('');
                        }
                        curCont.attr('class', 'single');
                        curCont = $('#number.single');

                        var numParts = String(data.number[0]);
                        numParts.split('');

                        var insHtml = '<span class="new">';
                        for (var i = 0;  i < numParts.length; i ++) {
                            insHtml += '<span>' + numParts.charAt(i) + '</span>';
                        }
                        insHtml += '</span>';

                        curCont.find('.new').attr('class', 'cur');
                        curCont.append(insHtml);

                        curCont.find('.cur').fadeOut(100, function() { $(this).remove(); });

                        var i = 1;
                        curCont.find('.new span').each(function() {
                            $(this)
                                .delay(parseInt(150/numParts.length)*(i ++))
                                .animate({'top': 0}, 'fast');
                        });

                        if (data.hash) {
                            saveDlg.prev().find('.ui-dialog-title').text('Сохранить это число');
                            saveDlg.attr('title', 'Сохранить это число');
                            saveDlg.find('.text').text('этим числом');
                            saveDlg.find('input[name="hash"]').val(data.hash);
                            $('#save-init').text('сохранить это число').attr('data-hash', data.hash)
                                .css('visibility', 'visible');
                        }
                    } else {
                        $('#caption').text('Случайные числа:');

                        curCont.attr('class', 'multi').css('min-height', curCont.height());
                        curCont = $('#number.multi');
                        curCont.html('<span class="cur"></span>');

                        var i = 1;
                        for (var n in data.number) {
                            $('<span> ' + data.number[n] + '</span>,')
                                .css({'opacity': 0})
                                .appendTo(curCont.find('.cur'))
                                .delay(250/data.number.length*(i ++))
                                .animate({'opacity': 1}, 200);
                        }

                        setTimeout(function() { curCont.css('min-height', '') }, 250);

                        if (data.hash) {
                            saveDlg.prev().find('.ui-dialog-title').text('Сохранить эти числа');
                            saveDlg.attr('title', 'Сохранить эти числа');
                            saveDlg.find('.text').text('этими числами');
                            saveDlg.find('input[name="hash"]').val(data.hash);
                            $('#save-init').text('сохранить эти числа').attr('data-hash', data.hash)
                                .css('visibility', 'visible');
                        }
                    }
                }
            }
        });
    });

    /* Сохранить число */
    $('#save-init').on('click', function() {
        var dlg = $('#save');
        var hash = $(this).attr('data-hash');

        if (hash) {
            dlg.dialog({
                width: 500,
                modal: true
            });
        }
    });

    /* Отправить форму сохранения */
    $('#save form').submit(function() {
        var name = $(this).find('input[name="name"]');
        var sum = $(this).find('input[name="sum"]');
        var err = false;

        if (!name.val()) {
            name.addClass('err');
            err = true;
        }

        if (sum.val() < 1) {
            sum.addClass('err');
            err = true;
        }

        if (!err) {
            $('#save').dialog('close');
        } else {
            return false;
        }
    });

    /* Сброс подсветки полей с ошибками */
    $('form').on('focus', '.err', function() {
        $(this).removeClass('err');
    });

    $('#save input[name="sum"]').keydown(function(e) {
        return enterOnlyNumbers($(this), e);
    });

    /* Пароль */
    $('#button.password').click(function() {
        var len = $("#slider").slider('value');
        var num = $('#password-number').attr('checked');
        var sym = $('#password-symbol').attr('checked');

        var curCont = $('#password');

        $.ajax({
            data: {'get_password': true, 'len': len, 'num': num, 'sym': sym},
            success: function(data) {
                if (!data.error) {
                    var passParts = String(data.password);
                    passParts.split('');

                    var insHtml = '<span class="new">';
                    for (var i = 0;  i < passParts.length; i ++) {
                        insHtml += '<span>' + passParts.charAt(i) + '</span>';
                    }
                    insHtml += '</span>';

                    curCont.find('.new').attr('class', 'cur');
                    curCont.append(insHtml);

                    curCont.find('.cur').fadeOut(100, function() { $(this).remove(); });

                    var i = 1;
                    curCont.find('.new span').each(function() {
                        $(this)
                            .delay(parseInt(200/passParts.length)*(i ++))
                            .animate({'top': 0}, 'fast');
                    });
                }
            }
        });
    });

    /* Счастливый билет */
    $('#button.ticket').click(function() {
        var curCont = $('#ticket');

        $.ajax({
            data: {'get_ticket': true},
            success: function(data) {
                var newClass = (true == data.lucky) ? 'lucky' : 'unlucky';

                curCont.find('.wrap').hide();
                curCont.attr('class', newClass);
                curCont.find('.wrap').text(data.ticket).fadeIn(200);

                if (true == data.lucky) {
                    curCont.find('.text').html('<span>Удача!</span> Испытайте её ещё раз!');
                } else {
                    curCont.find('.text').html('<span>Неудача...</span> Стоит попробовать ещё раз!');
                }

                $('#ad .stat').replaceWith(data.ad);
            }
        });
    });

    /* Мудрое высказывание */
    $('#button.saying').click(function() {
        var curCont = $('#saying');
        var req = true;

        if ($(this).hasClass('fav')) {
            req = 'fav';
            $(this).removeClass('fav');
        }

        $.ajax({
            data: {'get_saying': req},
            success: function(data) {
                var insHtml = data.saying.text;
                if (data.saying.author) {
                    insHtml += '<span class="author">— ' + data.saying.author + '</span>';
                }

                curCont.find('.text').hide().html(insHtml).fadeIn(200);
                if (req != 'fav') {
                    $('#caption').text('Мудрое высказывание:');
                    $('.vote').attr('id', 'saying-' + data.id).find('span').hide().fadeIn(200);
                } else {
                    $('#caption').text('Высказывание дня:');
                    $('.vote').attr('id', '').find('span').hide();
                }

                $('#share').attr('href', data.share);
            }
        });
    });

    /* Шутка */
    $('#button.joke').click(function() {
        var curCont = $('#joke');
        var req = true;

        if ($(this).hasClass('fav')) {
            req = 'fav';
            $(this).removeClass('fav');
        }

        $.ajax({
            data: {'get_joke': req},
            success: function(data) {
                var insHtml = data.joke;

                curCont.find('.text').hide().html(insHtml).fadeIn(200);
                if (req != 'fav') {
                    $('#caption').text('Шутка:');
                    $('.vote').attr('id', 'joke-' + data.id).find('span').hide().fadeIn(200);
                } else {
                    $('#caption').text('Шутка дня:');
                    $('.vote').attr('id', '').find('span').hide();
                }

                $('#share').attr('href', data.share);
            }
        });
    });

    /* Факт */
    $('#button.fact').click(function() {
        var curCont = $('#fact');
        var req = true;

        if ($(this).hasClass('fav')) {
            req = 'fav';
            $(this).removeClass('fav');
        }

        $.ajax({
            data: {'get_fact': req},
            success: function(data) {
                var insHtml = data.fact;

                curCont.find('.text').hide().html(insHtml).fadeIn(200);
                if (req != 'fav') {
                    $('#caption').text('Факт:');
                    $('.vote').attr('id', 'fact-' + data.id).find('span').hide().fadeIn(200);
                } else {
                    $('#caption').text('Факт дня:');
                    $('.vote').attr('id', '').find('span').hide();
                }

                $('#share').attr('href', data.share);
            }
        });
    });

    /* Голосование */
    $('.vote span').click(function() {
        var curCont = $('.vote');

        var vote = String(curCont.attr('id'));
        vote = vote.split('-');

        var type = vote[0];
        var item = vote[1];
        var rate = $(this).attr('class');

        curCont.removeAttr('id').find('span').fadeOut(200);

        $.ajax({
            data: {'vote': type, 'item': item, 'rate': rate},
            success: function() {
                //$('#button').click();
            }
        });
    });

    /* Популярное высказывание/шутка */
    $('.vote-fav').click(function() {
        $('#button').addClass('fav').click();
    });

    /* Всплывающее окно */
    $('.dialog-init').click(function() {
        $('#dialog').dialog({
            width: 500,
            modal: true
        });
    });

    /* Закрыть диалоговое окно */
    $('.ui-widget-overlay').live('click', function() {
        $('#dialog').dialog('close');
    });

    /* Ответ на вопрос */
    $('.answer .item:not(.comp)').live('click', function() {
        var elem = $(this);

        var qu = String($('.answer').attr('id'));
        qu = qu.split('-');
        qu = qu[1];

        var num = $(this).data('num');

        $.ajax({
            data: {'ans_question': qu, 'ans': num},
            success: function(data) {
                if ('ok' == data.suc) {
                    elem.addClass('suc');
                    $('.answer .item').addClass('comp');
                    $('#ad .prog').replaceWith(data.ad);
                } else if ('err' == data.suc) {
                    elem.addClass('err');
                    $('.answer').find('[data-num="' + data.cor + '"]').addClass('suc');
                    $('.answer .item').addClass('comp');
                    $('#ad .prog').replaceWith(data.ad);
                }
            }
        });
    });

    /* Вопрос */
    $('#button.question').click(function() {
        var curCont = $('#question');

        $.ajax({
            data: {'get_question': true},
            success: function(data) {
                var insHtml = data.text;

                curCont.find('.text').hide().html(insHtml).fadeIn(200);
                curCont.find('.answer').attr('id', 'question-' + data.id).hide()
                    .find('.item').attr('class', 'item');

                if (!data.all) {
                    for (var i = 1; i <= 4; i++) {
                        var ans = 'answer' + String(i);
                        curCont.find('[data-num="' + i + '"] > .ans').text(data[ans]);
                    }
                    curCont.find('.answer').fadeIn(200);
                }
            }
        });
    });

    /* Сбросить прогресс вопросов */
    $('.prog-reset').live('click', function() {
        $.ajax({
            data: {'res_question': true},
            success: function(data) {
                $('#ad .prog').replaceWith(data.ad);
            }
        });
    });

    /* Предсказание */
    $('#button.ask').click(function() {
        var cap = $('#caption');
        var ball = $('#ask').find('.ball');
        var emp = ball.find('.empty');
        var prod = ball.find('.prediction');

        var qu = $('#ask-question').val() || true;

        emp.fadeIn(250, function() {
            $.ajax({
                data: {'get_ask': qu},
                success: function(data) {
                    ball.effect('shake', function() {
                        if (data.qu) {
                            cap.text(data.qu);
                        } else{
                            cap.text('Шар говорит:');
                        }
                        $('#ask-question').val('');

                        prod.html(data.text);
                        emp.fadeOut(250);
                    });
                }
            });
        });
    });

    /* Последние предсказания */
    $('.dialog-prediction').click(function() {
        $.ajax({
            data: {'get_last_pred': true},
            success: function(data) {
                $('#last-prediction').html(data.text);

                $('#dialog').dialog({
                    width: 500,
                    modal: true
                });
            }
        });
    });

    /* Группа вконтакте */
    $('#fb .grp').hover(
        function() { $(this).stop(true, true).animate({height: 320}, 300); },
        function() { $(this).animate({height: 34}, 100); }
    );

    /* Информер о группе */
    if ($('#public').length) {
        $('#public').delay(800).queue(function(){
            $(this).dialog({
                width: 380,
                height: 390,
                modal: true,
                open: function() {
                    var top = $('.ui-dialog').offset().top;
                    $('.ui-dialog').css({'top': '-400px'}).animate({'top': top}, 1000, 'easeOutExpo');

                    VK.Widgets.Group("vk_group_dlg", {mode: 0, width: "350", height: "220", color1: 'FFFFFF', color2: 'b30000', color3: '000000'}, 60549401);
                }
            }).dequeue();
        });
    }
});
