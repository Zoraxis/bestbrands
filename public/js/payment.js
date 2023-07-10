let aSlide = 1, graph = 0, sign = 0, width = 0, gmove = 0, smove = 0, gpath = 0, spath = 0;
let moving = false;

//------------------------ADDRESS------------------------
let ajaxErr = '';
//------------------------ENDADDRESS------------------------

(function ($) {
    $(function () {
        $('body').addClass('no-overflow');

        updateScreen();
        $('#graph-cover').css('left', gmove);
        $('#sign-cover').css('left', smove);

        $( window ).resize(function() {
            updateScreen();
            $('#graph-cover').css('left', gmove + gpath);
            console.log(gmove + gpath);
            $('#sign-cover').css('left', smove + spath);
        });

        $.ajax({
            url: '/ajax/api/get',
            data: {
                'a': 'pricepost',
                'weight': $('#data-export').data('weight'),
            },
            type: 'GET',
            success: function (data) {
                data = data.data[0].Cost;
                $('#total-cart-cost').text(parseFloat($('#data-export').data('price')) + data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText)
            }
        });

        $('.next').click(function () {
            if($(this).hasClass('locked') || moving) return;
            moving = true;
            aSlide++;
            if(aSlide == 4) formOverview();
            updateNumbers();
            $("#graph-cover").stop().animate({
                left: graph + 221
            }, 790, function () { moving = false; gpath = gpath + 221});
            $("#sign-cover").stop().animate({
                left: sign + 200
            }, 1100, function () { moving = false; spath = spath + 200});
            updateSlides();
        });
        $('.prev').click(function () {
            if($(this).hasClass('locked') || moving) return;
            moving = true;
            aSlide--;
            if(aSlide == 0) window.location.replace("/cart");
            updateNumbers();
            $("#graph-cover").stop().animate({
                left: graph - 221
            }, 790, function () { moving = false; gpath = gpath - 221});
            $("#sign-cover").stop().animate({
                left: sign - 200
            }, 1100, function () { moving = false; spath = spath - 200});
            updateSlides();
        });
    });
}(jQuery));

function UpdateTicks() {
    if(aSlide == 1){
        $('#tick1').fadeOut('fast', ()=>{
            $('#n1').fadeIn('fast')
        })
    }
    if (aSlide == 2){
        $('#n1').fadeOut('fast', ()=>{
            $('#tick1').fadeIn('fast')
        });
        $('#tick2').fadeOut('fast', ()=>{
            $('#n2').fadeIn('fast')
        })
        $('#address-lock').fadeIn('fast').parent().addClass('locked');
    }
    if(aSlide == 3){
        $('#n2').fadeOut('fast', ()=>{
            $('#tick2').fadeIn('fast')
        });
    }
}
function updateScreen() {
    width = $('#main-screen').width();
    gmove = ((width - 486) / 2) + 46;
    smove = ((width - 555) / 2) + 220;
}
function updateNumbers() {
    graph = parseInt($('#graph-cover').css('left'));
    sign = parseInt($('#sign-cover').css('left'));
}
function updateSlides(){
    if(aSlide == 2) loadAddress();
    if(aSlide == 3) loadCards();
    UpdateTicks();
    $('.aslide').removeClass('aslide').fadeOut('fast', () => {$('#s'+aSlide).addClass('aslide').fadeIn('fast');});
}

//------------------------ADDRESS------------------------
async function ajax(url, data) {
    let result;

    result = await $.ajax({
        'url': url,
        'type': 'GET',
        'dataType': 'json',
        'data': data,
        'success': function (data) {
            console.log(data);
            return data;
        },
        'error': function (xhr, status, error) {
            console.log(xhr.responseText);
            ajaxErr = xhr.responseText
            return xhr.responseText;
        }
    });


    return result;

}

async function loadAddress() {
    $('#paddress').children('.address-option').next('hr').detach();
    $('#paddress').children('.address-option').detach();
    let data = await ajax('/ajax/profile/get', {
        'a': 'address'
    });
    if (data.length == 0) {
        $('#no-address').fadeIn();
        
    } else {
        let address = $('#paddress');
        data.forEach(x => {
            let post = 'Нова Пошта';
            if (x.post_type != 'new') post = 'Укр Пошта';
            address.append(`
                <div data-id="${x.id}" id="a${x.id}" class="flex address-option">
                    <input name="address" type="radio" class="addr-radio">
                    <div class="left-content">
                        <div class="fs16 fw400">${post}</div>
                        <div class="fs22 fw500">${x.place}</div>
                    </div>
                </div>
                <hr>
            `)
        });
        $('.addr-radio').click(function () {
            $('#address-lock').fadeOut('fast',function (){
                $(this).parent().removeClass('locked');
            });
        });
    }
}
//------------------------ENDADDRESS------------------------

async function loadCards(){
    let data = await ajax('/ajax/profile/get', {
        'a': 'card'
    });
    $('.crem').detach();
    data.forEach(x => {
        console.log(x);
        $('#cards').prepend(`
           <div class="flex flex-between flex-column card crem ${(Math.random() < 0.5) ? 'preset1' : 'preset2'}">
                <div class="row">
                    <div></div>
                    <input class="card-del card-radio" type="radio" name="card-radio">
                </div>
                <div class="ml33 mb36">
                    <h2 class="fw500 fs22 mb24">${x.number}</h2>
                    <h2 class="fw500 fs12">${x.date}</h2>
                    <h2 class="fw500 fs14">${x.fullname}</h2>
                </div>
           </div>`
        );
    });
    $('.card-radio').click(function () {
        $('#card-lock').fadeOut('fast',function (){
            $(this).parent().removeClass('locked');
        });
    });
}

function formOverview(){
    $('.no-overflow').removeClass('no-overflow');
    $('#cart').fadeOut('fast')
    $('#main-screen').addClass('w100');
}