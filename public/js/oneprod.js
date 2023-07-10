
const bindOneProdFuncs = () =>{
    try {
        $('.box').click(function (){
            if(!$(this).hasClass('chosen')){
              $('.chosen').removeClass('chosen');
              $(this).addClass('chosen');
              $('.err').text('');
            }
          });
          $('#del-item-btn').click(function () {
              $('#over-content').html(`<div class="cart-del-conf">
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
              <h3 class="fs15 fw400 mb24">Ви впевнені, що хочете видалити товар?</h3>
              <div class="flex">
                  <a onclick="ItemDel(${$(this).data('id')}) " class="btn2 outline-btn mr12 pointer">Видалити</a>
                  <a onclick="$('#overlay').fadeOut('fast',() => {$('#over-content').empty()})" class="btn2 azure-btn pointer">Залишити</a>
              </div>
          </div>`)
              $('#overlay').fadeIn('fast');
          });
    } catch {
        setTimeout("bindFuncs()", 10);
    }
}

(function ($) {
    $(function () {
        bindOneProdFuncs();
    });
}(jQuery));

function ItemDel(id){
    $.ajax({
        'url': '/ajax/general/set',
        'type': 'GET',
        'dataType': 'json',
        'data': {
            'a': 'delitem',
            'id': id
        },
        'success': function (data) {
            window.location.replace("/");
        },
        'error': function (data) {
            window.location.replace("/");
        }
    });
}

function ToggleCart(itemId, a) {
    if ($('#size-list .chosen').length == 0) {
      $('.err').text('Розмiр не обрано');
      return false;
    }
    $('.err').text('');
    $.ajax({
        'url': '/products/'.itemId,
        'type': 'GET',
        'dataType': 'json',
        'data': {
            'a': a,
            'sz': $('#size-list .chosen').text()
        },
        'success': function (data) {
            if (a == 'w') {
                if (!data.is_wishlist) {
                    $('#wishlist').attr('fill', 'red');
                } else {
                    $('#wishlist').attr('fill', 'none');
                }
            } else if (a == 'c') {
                let count = parseInt($('#cart-count').text());
                if (!data.is_cart) {
                    if (count == 0) {
                        $('#cart-num').fadeIn();
                    }
                    $('#cart-count').text(count + 1);
                    $('#add-cart-btn').addClass('in-cart').children().first().text('Додано до кошику');
                } else {
                    if (count == 1) {
                        $('#cart-num').fadeOut();
                    }
                    $('#cart-count').text(count - 1);
                    $('#add-cart-btn').removeClass('in-cart').children().first().text('Додати до кошику');
                }
            }
        },
        'error': function (data) {
            $('err').text('Невiдома помилка');
        }
    });
    
}
