(function ($) {
    $(function () {
        $('.profile-link').click(function () {
            $('#p' + $('.pl-active').data('content')).toggle().removeClass('c-active');
            $('.pl-active').removeClass('pl-active');
            $(this).addClass('pl-active');
            $('#p' + $(this).data('content')).toggle().addClass('c-active');
        });

        $('.lever').click(function () {
            $('.focus').toggleClass('left');
        })

        $('.edit-btn').click(function () {
            $(this).parent().hide();
            $('#' + $(this).data('edit')).show();
        });

        $('#tel').on('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = '+(' + x[1] + ') ' + x[2] + '-' + x[3] + '-' + x[4] + '-' + x[5];
        });
    });
}(jQuery));

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
async function loadCards(){
    if ($('#pcard-script').length == 0) {
        $('link').last().after(`<link href="/css/profile/card.css" rel="stylesheet">`)
        $('script').last().after(`<script id="pcard-script" src='/js/profile/card.js'></script>`);
    }
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
                    <svg data-id="${x.id}" class="overflow card-del pointer" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <g clip-path="url(#clip0_265_1062)">
                            <path d="M3 3L15 15" stroke="white" stroke-width="1.5"/>
                            <path d="M3 15L15 3" stroke="white" stroke-width="1.5"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_265_1062">
                                <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="ml33 mb36">
                    <h2 class="fw500 fs22 mb24">${x.number}</h2>
                    <h2 class="fw500 fs12">${x.date}</h2>
                    <h2 class="fw500 fs14">${x.fullname}</h2>
                </div>
           </div>`
        );
        $('.card-del').click(function (){
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
            <h3 class="fs15 fw400 mb24">Ви впевнені, що хочете видалити цю картку?</h3>
            <div class="flex">
                <a onclick="CardDel(${$(this).data('id')}) " class="btn2 outline-btn mr12 pointer">Видалити</a>
                <a onclick="$('#overlay').fadeOut('fast',() => {$('#over-content').empty()})" class="btn2 azure-btn pointer">Залишити</a>
            </div>
        </div>`)
            $('#overlay').fadeIn('fast');
        });

    });
}
async function loadAddress() {
    if ($('#paddress-script').length == 0) {
        $('link').last().after(`<link href="/css/profile/address.css" rel="stylesheet">`)
        $('script').last().after(`<script id="paddress-script" src='/js/profile/address.js'></script>`);
    }

    $('#paddress').children('.address-option').detach();
    let data = await ajax('/ajax/profile/get', {
        'a': 'address'
    });
    if (data.length == 0) {
        $('#no-address').fadeIn();
        
    } else {
        let address = $('#paddress');
        address.children().first().fadeIn("fast");
        data.forEach(x => {
            let post = 'Нова Пошта';
            if (x.post_type != 'new') post = 'Укр Пошта';
            address.append(`
                <div data-id="${x.id}" id="a${x.id}" class="properties content-box address-option">
                    <div class="line-flex">
                        <div class="left-content">
                            <div class="fs16 fw400">${post}</div>
                            <div class="fs22 fw500">${x.place}</div>
                            <a class="fs14 underline c47B pointer" onclick="editAddress(this.parentNode.parentNode.parentNode.dataset.id)">Редагувати</a>
                        </div>
                        <a class="pointer del-address" onclick="addressDeleteConfirm(this.parentNode.parentNode.dataset.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <g clip-path="url(#clip0_262_279)">
                                    <path d="M17.8252 20.6595L19.3225 6.65952C19.4173 5.77302 18.7226 5 17.831 5H6.21388C5.30649 5 4.60687 5.79937 4.72711 6.69877L6.59877 20.6988C6.69836 21.4437 7.33393 22 8.08554 22H16.3337C17.1004 22 17.7437 21.4218 17.8252 20.6595Z" stroke="#1D1E20" stroke-width="1.5"/>
                                    <path d="M10 8.5L10.5 18.5" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M14 8.5L13.5 18.5" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M7.5 5L7.7911 3.2534C7.91165 2.53012 8.53743 2 9.27069 2H14.7293C15.4626 2 16.0884 2.53012 16.2089 3.2534L16.5 5" stroke="#1D1E20" stroke-width="1.5"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_262_279">
                                        <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                    <small class="addr-err"></small>
                </div>
            `)
        });
    }
}

async function loadWishlist() {
    let data = await ajax('/ajax/profile/get', {
        'a': 'wishlist'
    });
    data.forEach(x => {
        console.log(x);
        $('.wish.items').append(
            `<div class="w-item">
            <div class="line-flex">
                <div class="left-content">
                    <img src="/images/${x.image}" style="height:100px"/>
                    <img src="/images/${x.image2}" style="height:100px"/>
                    <div class="tab-title fs20 fw400">${x.name}</div>
                    <div class="tab-title fs14 fw400">${x.content}</div>
                </div>
                <a class="pointer del-address" onclick="addressDeleteConfirm(this.parentNode.parentNode.dataset.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_262_279)">
                                        <path d="M17.8252 20.6595L19.3225 6.65952C19.4173 5.77302 18.7226 5 17.831 5H6.21388C5.30649 5 4.60687 5.79937 4.72711 6.69877L6.59877 20.6988C6.69836 21.4437 7.33393 22 8.08554 22H16.3337C17.1004 22 17.7437 21.4218 17.8252 20.6595Z" stroke="#1D1E20" stroke-width="1.5"/>
                                        <path d="M10 8.5L10.5 18.5" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14 8.5L13.5 18.5" stroke="#1D1E20" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M7.5 5L7.7911 3.2534C7.91165 2.53012 8.53743 2 9.27069 2H14.7293C15.4626 2 16.0884 2.53012 16.2089 3.2534L16.5 5" stroke="#1D1E20" stroke-width="1.5"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_262_279">
                                            <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
            </div>
        </div>`);
    });
}

function loadCart() {

}

async function SaveData(a) {
    $('.invalid').html('');
    try {
        let data = await ajax('/ajax/profile/edit', {
            'a': a,
            'name': $('#name').val(),
            'surname': $('#surname').val(),
            'middlename': $('#middlename').val(),
            'email': $('#email').val(),
            'tel': $('#tel').val(),
        });
        data = data.data;

        if (a == 'main') {
            $('#' + a + '-box').show();
            $('#' + a + '-info').hide();
            $('#main-box .property')
                .html($('#surname').val() + ' ' + $('#name').val() + ' ' + $('#middlename').val())
                .next('.property').html($('#email').val())
                .next('.property').html($('#tel').val());
        }
    } catch {
        let n = ajaxErr.substr(ajaxErr.indexOf('.'));
        if (ajaxErr.includes('empty')) {
            $('#' + pos[n]).next().html('Can\'t be empty');
        } else if (ajaxErr.includes('email')) {
            $('#' + pos[n]).next().html('Invalid email address');
        } else if (ajaxErr.includes('tel')) {
            $('#' + pos[n]).next().html('Invalid phone number');
        }
    }
}
async function SaveExtraData(a) {
    $('.invalid').html('');
    try {
        let sex = 'f';
        if ($('#male').is(':checked')) sex = 'm';
        let data = await ajax('/ajax/profile/edit', {
            'a': a,
            'sex': sex,
            'date': $('#birthday').val(),
        });
        data = data.data;

        $('#' + a + '-box').show();
        $('#' + a + '-info').hide();
        if (sex == 'f') sex = 'Мiсс';
        else sex = "Мiстер";
        $('#extra-box .property').first().html(sex).next('.property').html($('#birthday').val());
    } catch (error) {
        console.log(error);
    }
}
