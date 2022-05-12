$(function(){
    var lastScrollTop = 0, delta = 5;
    $(window).scroll(function(){
        var nowScrollTop = $(this).scrollTop();
        if(Math.abs(lastScrollTop - nowScrollTop) >= delta){
            if (nowScrollTop > lastScrollTop){
                $('#filter').addClass('_hide');
            } else {
                $('#filter').removeClass('_hide');
           }
        lastScrollTop = nowScrollTop;
        }
    });
});