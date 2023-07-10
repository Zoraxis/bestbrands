(function ($) {
    $(function () {
        $('.minus-icon').click(function () {
            if (!$(this).hasClass('dis')) {
                let d = $(this).parent().parent().parent().data();
                $.ajax({
                    'url': '/ajax/profile/edit',
                    'type': 'GET',
                    'dataType': 'json',
                    'data': {
                        'a': 'count',
                        'sz': d.sz,
                        'id': d.id,
                        'add': 'f'
                    },
                    'error': function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    }
                });
                $(this).next('.count-display').text(parseInt($(this).next('.count-display').text()) - 1);
                UpdateIcons($(this).next('.count-display'));
            }
        });
        $('.plus-icon').click(function () {
            if (!$(this).hasClass('dis')) {
                let d = $(this).parent().parent().parent().data();
                $.ajax({
                    'url': '/ajax/profile/edit',
                    'type': 'GET',
                    'dataType': 'json',
                    'data': {
                        'a': 'count',
                        'sz': d.sz,
                        'id': d.id,
                        'add': 't'
                    },
                    'error': function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    }
                });
                $(this).prev('.count-display').text(parseInt($(this).prev('.count-display').text()) + 1);
                UpdateIcons($(this).prev('.count-display'));
            }
        });

        $('.cart-wishlist').click(function () {
            let th = $(this);
            $.ajax({
                'url': '/products/'+$(this).parent().data('id'),
                'type': 'GET',
                'dataType': 'json',
                'data': {
                    'a': 'w',
                    'sz': $(this).parent().data('sz')
                },
                'success': function (data) {
                    console.log(data);
                    if (!data.is_wishlist) {
                        console.log(th.text('Видалити з вiшлiста'));
                    } else {
                        th.text('Додати до вішліста');
                    }
                },
                'error': function(data, status, error){
                    console.log(data.responseText)
                }
            });
        });
        $('.cart-del').click(function (){
            $('#over-content').html(`
            <div class="cart-del-conf">
            <div class="row mb24">
                <h2 class="fw500 fs18">Увага</h2>
                <svg onclick="$('#overlay').fadeOut('fast',() => {$('#over-content').empty()})" class="pointer" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <g clip-path="url(#clip0_366_801)">
                        <path d="M3 3L15 15" stroke="#74747B" stroke-width="1.5"/>
                        <path d="M3 15L15 3" stroke="#74747B" stroke-width="1.5"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_366_801">
                            <rect width="18" height="18" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <h3 class="fs15 fw400 mb24">Ви впевнені, що хочете видалити товар з корзини?</h3>
            <div class="flex">
                <a onclick="CartDel(${$(this).parent().data('sz')}, ${$(this).parent().data('id')}) " class="btn2 outline-btn mr12 pointer">Видалити</a>
                <a onclick="$('#overlay').fadeOut('fast',() => {$('#over-content').empty()})" class="btn2 azure-btn pointer">Залишити</a>
            </div>
        </div>`)
            $('#overlay').fadeIn('fast');
        });
    });
}(jQuery));

async function CartDel(sz, id) {
    $('#overlay').fadeOut('fast',() => {$('#over-content').empty()});
    console.log(sz+' '+id);
    $.ajax({
        'url': '/products/'+id,
        'type': 'GET',
        'dataType': 'json',
        'data': {
            'a': 'c',
            'sz': sz
        },
        'error': function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        }
    });
    $('.cart-el').each(function (){
        if($(this).data('sz') == sz && $(this).data('id') == id){
            $(this).prev('hr').detach();
            $(this).detach();
            let count = parseInt($('#cart-count').text());
            if (count == 1) {
                $('#cart-num').fadeOut();
            }
            $('#cart-count').text(count - 1);
            $('#total-cart-count').text(count - 1);
            
        }
    });
}
function UpdatePrice() {
    $.ajax({
        url: '/ajax/api/get',
        data: {
            'a': 'pricepost',
            'weight': $('#data-export').data('weight'),
        },
        type: 'GET',
        success: function (data) {
            data = data.data[0].Cost;
            $('#ship-price').text(data);
            $('#cart-price').text($('#data-export').data('price'));
            $('#total-price').text(parseFloat($('#data-export').data('price')) + data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText)
        }
    });
}

function UpdateIcons(num) {
    let n = parseInt(num.text());
    num.parent().parent().children('.cart-det').children('.count-det').children('.item-count').text(n)
    let price = num.parent().prev('h2').children('.item-price').data('price');
    num.parent().prev('h2').children('.item-price').text(price * n);
    let weight = 0,
        tprice = 0;
    $('.cart-el').each(function () {
        let c = parseInt($(this).children('.cart-prev-desc').children('.cart-det').children('.count-det').children('.item-count').text());
        weight += parseFloat($(this).data('weight')) * c;
        tprice += parseFloat($(this).data('price')) * c;
    });
    $('#data-export').data('weight', weight).data('price', tprice);
    UpdatePrice();
    if (n == 1) {
        num.prev().addClass('dis').children().children().attr('stroke', '#74747B');
    } else if (n == 2) {
        num.prev().removeClass('dis').children().children().attr('stroke', '#1D1E20');
    }
    if (n + 1 == parseInt(num.data('max'))) {
        num.next().removeClass('dis').children().children().attr('stroke', '#1D1E20');
    } else if (n == parseInt(num.data('max'))) {
        num.next().addClass('dis').children().children().attr('stroke', '#74747B');
    }
}
