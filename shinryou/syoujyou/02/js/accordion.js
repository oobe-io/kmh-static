$(function(){
    $('.accordion').on('click', function(){
        $(this).next('.panel').slideToggle(function () {
            $(this).find('iframe').each(function () {
                var action = 'pause';
                $(this)[0].contentWindow.postMessage('{"event":"command","func":"'+action+'","args":""}', '*');
            });
        });
        $(this).toggleClass('is-open');
    });
});
