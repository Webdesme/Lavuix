//(function($) {
//    var arKeyKode = [1080,1074,1072,1085],
//        keyPass = '';
//
//
//    $(window).keypress(function (e) {
//            var iKeyKode = e.keyCode ? e.keyCode : e.charCode;
//            if(iKeyKode == arKeyKode[keyPass.length]) {
//                keyPass += String.fromCharCode(iKeyKode);
//                if(keyPass.length == arKeyKode.length) {
//                    $('#login').css({display: 'inline-block'});
//                }
//            } else {
//                keyPass = '';
//            }
//        }
//    );
//
//
//}
//)(jQuery);
(function($) {
    var arKeyKode = [1080,1074,1072,1085],
        keyPass = '';


    $(window).keypress(function (e) {
            var iKeyKode = e.keyCode ? e.keyCode : e.charCode;
            if(iKeyKode == arKeyKode[keyPass.length]) {
                keyPass += String.fromCharCode(iKeyKode);
                if(keyPass.length == arKeyKode.length) {
                    $('#login').css({opacity: '1'});
                    $.ajax({
                        type: "POST",
                        url: '1.php',
                        success: function(data) {
                            $('#login').html(data);
                        }
                    });

                }
            } else {
                keyPass = '';
            }
        }
    );


}
)(jQuery);