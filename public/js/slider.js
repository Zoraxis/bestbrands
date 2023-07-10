$(function () {
    let moving = false;

    var slideCount = $(".slider ul img").length;
    var slideWidth = $(".slider ul img").width();
    var slideHeight = $(".slider ul img").height();
    var slideUlWidth = slideCount * slideWidth;

    $(".slider").css({
        "max-width": slideWidth,
        "height": slideHeight
    });
    $(".slider ul").css({
        "width": slideUlWidth,
        "margin-left": -slideWidth
    });

    $(".slider ul img:last-child").prependTo($(".slider ul"));

    let repeat = 1;

    function moveLeft(a = true) {
        $(".slider ul").stop().animate({
            left: +slideWidth
        }, 790 - (repeat * 90), function () {
            $(".slider ul img:last-child").prependTo($(".slider ul"));
            $(".slider ul").css("left", "");
            moving = false;
            if (a) {
                if ($('.active-slide').removeClass('active-slide').prev().first().addClass('active-slide').length == 0) $('.img-prev').children().last().addClass('active-slide');
            }
            i = 0;
            $('.slider ul').children().each(function () {
                $(this).attr('id', 'i' + (i + 1));
                i++;
            });
            repeat--;
            if (repeat > 0) moveLeft(a);
        });
    }
    let i = 0;;

    function moveRight(a = true) {
        $(".slider ul").stop().animate({
            left: -slideWidth
        }, 790 - (repeat * 90), function () {
            $(".slider ul img:first-child").appendTo($(".slider ul"));
            $(".slider ul").css("left", "");
            moving = false;
            if (a) {
                if ($('.active-slide').removeClass('active-slide').next().first().addClass('active-slide').length == 0) $('.img-prev').children().first().addClass('active-slide');
            }

            i = 0;
            $('.slider ul').children().each(function () {
                $(this).attr('id', 'i' + (i + 1));
                i++;
            });
            repeat--;
            if (repeat > 0) moveRight(a);
        });
    }

    $(".next").click(function () {
        repeat = 1;
        if (!moving) moveRight();
        moving = true;
    });

    $(".prev").click(function () {
        repeat = 1;
        if (!moving) moveLeft();
        moving = true;
    });

    let newId = -1;
    let thisId = -1;
    $('.slider-option').click(function (e) {
        if (!$(this).hasClass('active-slide') && !moving) {
            newId = $('.active-slide').removeClass('active-slide').data('id');
            thisId = $(this).addClass('active-slide').data('id');
            if (newId < thisId) {
                repeat = thisId - newId;
                moveRight(false);
                moving = true;
            } else {
                repeat = newId - thisId;
                moveLeft(false);
                moving = true;
            }
        }
    })
});
