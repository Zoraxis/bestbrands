let cajaxErr;
let exdata;
async function ajax(url, data) {
    let result;

    result = await $.ajax({
        'url': url,
        'type': 'GET',
        'dataType': 'json',
        'data': data,
        'success': function (data) {
            console.log(data);
            exdata = data;
            return data;
        },
        'error': function (xhr, status, error) {
            console.log(xhr.responseText);
            cajaxErr = xhr.responseText
            return xhr.responseText;
        }
    });
    return result;
}

const bindFuncs = () => {
    try {
        $(".category-nav").hide();
        $(".info-block").hide();
        $("body").removeClass("load");

        $(".t-link").mouseenter(function (e) {
            $(".l-active").removeClass('l-active');
            $(this).addClass('l-active');

            let was = $(".blink-a");
            was.removeClass('blink-a');
            was.fadeOut("fast", () => {
                $(`#${e.target.getAttribute('value')}`).addClass('blink-a');
                $(".blink-a").fadeIn();
            });
        })

        $('#nav').mouseleave(function () {
            try {
                let a = $(".info-a");
                a.slideUp()
                a.removeClass("info-a");
            } catch {}

            $(".blink-a").removeClass("blink-a");
            $("#cart-prev").fadeOut('fast')
        });

        let target, del;
        $('.b-link').mouseenter(function (e) {
            $(".l-active.b-link").removeClass("l-active");
            $(this).addClass('l-active');

            del = $(".info-a");
            del.removeClass("info-a");
            del.fadeOut('fast');

            target = $(`#${e.target.getAttribute('value')}`);
            target.slideDown(400);
            target.addClass("info-a");
        });

        $('#cart-icon').mouseenter(function () {
            if (parseInt($('#cart-count').text()) > 0) {
                $('#cart-prev').fadeIn('fast');
                $('#cart-title').text(`Кошик (${$('#cart-count').text()})`);
                loadCartItems();
            }
        });
    } catch {
        console.log('err')
        setTimeout("bindFuncs()", 10);
    }
}

(function ($) {
    $(function () {
        bindFuncs();
    });
}(jQuery));

async function loadCartItems(){
    let citems = await ajax('/ajax/profile/get', {
        'a': 'cart',
    });
    $('#cart-prev').children('.cart-prev-el').detach();
    let dest = $('#cart-ins');
    let price = 0;
    citems.forEach(x => {
        dest.after(`
        <div class="cart-prev-el flex mb14">
            <img src="/images/${x.image}"/>
            <div class="cart-prev-desc">
                <h2 class="fw700 fs16 mb8">${x.name}</h2>
                <h2 class="fw400 fs10 c47B mb14">${x.content}</h2>
                <div class="fw400 fs10 c47B mb14 cart-det">
                    <div>${x.sz}</div>
                    <div>
                        <svg class="overflow" xmlns="http://www.w3.org/2000/svg" width="3" height="3" viewBox="0 0 3 3" fill="none">
                            <circle cx="1.5" cy="0" r="1.5" fill="#C9C9CF"/>
                        </svg>
                    </div>
                    <div>Кiлькiсть: ${x.quant}</div>
                </div>
                <h2 class="fs12 fw700 cE20">${x.price}₴</h2>
            </div>
        </div>
        `);
        price += parseFloat(x.price);
    });
    $('#cart-total-price').text(price+'₴');
}
