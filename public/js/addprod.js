let sizes = [];

function addSize() {
    if ($('#text').val() != '' && $('#count').val() != '') {
        if (sizes.findIndex(x => x.n == $('#text').val().toUpperCase()) != -1) {
            sizes.find(x => x.n == $('#text').val().toUpperCase()).c = $('#count').val()
        } else {
            sizes.push({
                'n': $('#text').val().toUpperCase(),
                'c': $('#count').val(),
            });
        }
        loadSizes();
    }
}

function loadSizes() {
    $('#size-list').children('.sz').remove();
    let sl = $('#size-list');
    sizes.forEach(x => {
        sl.append(`
            <div class="box sz ${x.c <= 0 ? 'outof' : ''}">
                <div>${x.n}</div>
                <div>(${x.c})</div>
                <svg class="del-sz" class="pointer" xmlns="http://www.w3.org/2000/svg" version="1.1" id="cross-11" width="24px" height="24px" viewBox="0 0 11 11">
                    <path d="M2.2,1.19l3.3,3.3L8.8,1.2C8.9314,1.0663,9.1127,0.9938,9.3,1C9.6761,1.0243,9.9757,1.3239,10,1.7&#10;&#9;c0.0018,0.1806-0.0705,0.3541-0.2,0.48L6.49,5.5L9.8,8.82C9.9295,8.9459,10.0018,9.1194,10,9.3C9.9757,9.6761,9.6761,9.9757,9.3,10&#10;&#9;c-0.1873,0.0062-0.3686-0.0663-0.5-0.2L5.5,6.51L2.21,9.8c-0.1314,0.1337-0.3127,0.2062-0.5,0.2C1.3265,9.98,1.02,9.6735,1,9.29&#10;&#9;C0.9982,9.1094,1.0705,8.9359,1.2,8.81L4.51,5.5L1.19,2.18C1.0641,2.0524,0.9955,1.8792,1,1.7C1.0243,1.3239,1.3239,1.0243,1.7,1&#10;&#9;C1.8858,0.9912,2.0669,1.06,2.2,1.19z"/>
                </svg>
            </div>
        `)
    });
    $('.del-sz').click(function () {
        const objWithIdIndex = sizes.findIndex(x => x.n == $(this).parent().children().first().text().toUpperCase());
        if (objWithIdIndex > -1) {
            sizes.splice(objWithIdIndex, 1);
        }
        loadSizes();
    })
}

//------------------------SLIDER------------------------

let moving = false;

var slideCount;
var slideWidth;
var slideHeight;
var slideUlWidth;

function updateSlides() {
    slideCount = $(".slider ul img").length;
    slideWidth = $(".slider ul img").width();
    slideHeight = $(".slider ul img").height();
    slideUlWidth = slideCount * slideWidth;
    if (slideCount > 0) {
        $(".slider").fadeIn();
    } else $(".slider").fadeOut();

    $(".slider").css({
        "max-width": slideWidth,
        "height": slideHeight
    });
    $(".slider ul").css({
        "width": slideUlWidth,
        "margin-left": -slideWidth
    });
    if (slideCount == 1) {
        $(".slider ul").css({
            "margin-left": 0
        });
    }
    $(".slider ul img:last-child").prependTo($(".slider ul"));
}
updateSlides();



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


//------------------------END SLIDER------------------------



let images = [];
(function ($) {
    $(function () {
        $('#img').on('change', function (e) {
            if ($(this).val() == '') return;
            console.log($('#img-form')[0]);
            var fd = new FormData($('#img-form')[0]);
            fd.append('file', $('#img-form')[0]);

            $.ajax({
                url: '/img-upload/',
                data: fd,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                type: 'POST',
                success: function (data) {
                    images.push(data);
                    console.log(images);
                    $("#img").val('');
                    loadImages();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText)
                }
            });
            e.preventDefault();
            return false;
        })
    });
}(jQuery));

let i = -1;

function loadImages() {
    let imgs = $('.img-dest').empty();
    let imgsp = $('.img-predest').empty();
    let selectImg1 = $('#img1').empty();
    let selectImg2 = $('#img2').empty();
    i = 0;
    images.forEach(x => {
        imgs.append(`<img id="i${i+1}" src="/images/${x}">`);
        imgsp.append(`<div data-id="${i+1}" class="slider-option pointer ${i==0?'active-slide':''}">
        <svg class="del-img" xmlns="http://www.w3.org/2000/svg" version="1.1" id="cross-11" width="24px" height="24px" viewBox="0 0 11 11">
            <path fill="white" d="M2.2,1.19l3.3,3.3L8.8,1.2C8.9314,1.0663,9.1127,0.9938,9.3,1C9.6761,1.0243,9.9757,1.3239,10,1.7
c0.0018,0.1806-0.0705,0.3541-0.2,0.48L6.49,5.5L9.8,8.82C9.9295,8.9459,10.0018,9.1194,10,9.3C9.9757,9.6761,9.6761,9.9757,9.3,10
c-0.1873,0.0062-0.3686-0.0663-0.5-0.2L5.5,6.51L2.21,9.8c-0.1314,0.1337-0.3127,0.2062-0.5,0.2C1.3265,9.98,1.02,9.6735,1,9.29
C0.9982,9.1094,1.0705,8.9359,1.2,8.81L4.51,5.5L1.19,2.18C1.0641,2.0524,0.9955,1.8792,1,1.7C1.0243,1.3239,1.3239,1.0243,1.7,1
C1.8858,0.9912,2.0669,1.06,2.2,1.19z"></path>
        </svg>
        <span class="img-num">${i+1}</span>
        <img src="/images/${x}"></div>`);
        selectImg1.append(`<option value="${i}">${i+1}</option>`);
        selectImg2.append(`<option value="${i}">${i+1}</option>`);
        i++;
    });
    $('.del-img').click(function () {
        images.splice(parseInt($(this).parent().data('id')) - 1, 1);
        loadImages();
    });
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
    updateSlides();
}

$('#add-item').click(function (){
    let pos1 = parseInt($('#img1').find(":selected").val());
    let pos2 = parseInt($('#img2').find(":selected").val());
    if(pos1 == pos2) return;
    let img1 = images[pos1]
    images.splice(pos1, 1)
    if(pos1 < pos2) pos2--;
    let img2 = images[pos2]
    images.splice(pos2, 1);
    let imgs = '';
    for(let i = 0; i < images.length; i++){
        imgs += images[i];
        if(i + 1 != images.length) imgs += ';';
    }
    let sz = '';
    let count = 0;
    for(let i = 0; i < sizes.length; i++){
        sz += sizes[i].n + '.' + sizes[i].c;
        count += sizes[i].c;
        if(i + 1 != sizes.length) sz += ' ';
    }
    $.ajax({
        url: '/ajax/general/set',
        data: {
            "a": 'additem',
            "img1": img1,
            "img2": img2,
            "imgs": imgs,
            "name": $('#brand').find(":selected").text(),
            "brand": $('#brand').find(":selected").val(),
            "cat": $('#category').find(":selected").val(),
            "type": $('#sex').find(":selected").val(),
            "content": $('#name').val(),
            "price": $('#price').val(),
            "weight": $('#weight').val(),
            "sz": sz,
            "count": count,
        },
        type: 'GET',
        success: function (data) {
            window.location.replace("/");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText)
        }
    });
});