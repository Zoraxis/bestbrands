let ajaxErr = '';
let timer = 0;
let warehouseId = -1;
let cityId = -1;
let req = '';
let length = -1;
let postType = 'new';
let addrId = -1;


$('#post-id').on('input', function (e) {
    if (/\D/g.test(this.value)) {
        this.value = this.value.replaceAll(/\D/g, '');
        $('#pid-err').show().html('Тiльки числа, будь ласка');
    } else {
        initDelay('id');
        $('#pid-err').html(' ');
        $('#ids-dropdown').empty();
    }
});
$('#city-post').on('input', function (e) {
    if (/[^А-Яа-яІіЇїҐґЄє]/.test(this.value)) {
        this.value = this.value.replaceAll(/[^А-Яа-яІіЇїҐґЄє]/g, '');
        $('#pcity-err').fadeIn().html('Тiльки українською, будь ласка');
    } else {
        initDelay('city');
        $('#pcity-err').html(' ');
        $('#cities-dropdown').empty();
    }
});

$('#city-post').parent().dblclick(function () {
    if ($(this).children('#city-post').prop('disabled')) {
        $(this).parent().next().fadeOut('fast');
        $(this).children('#city-post').prop('disabled', false).focus().val('');
        $('#post-id').val('').parent().fadeOut('fast');
        cityId = -1;
        $('#pcity-err').html(' ');

    }
});
$('#post-id').parent().dblclick(function () {
    if ($(this).children('#post-id').prop('disabled')) {
        $(this).parent().next().fadeOut('fast');
        $(this).children('#post-id').prop('disabled', false).focus().val('');
        $('#pid-err').html(' ');
    }
});
$('#add-address-btn').click(function () {
    if (length < 5) {
        $('#ea-address').fadeIn('fast').data('action', 'add');
    }
});
$('#add-new-address-btn').click(function () {
    $('#no-address').detach();
    $('#ea-address').show().data('action', 'new');
});


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

async function editAddress(a) {
    if ($('#ea-address:visible').length > 0) {
        $('#a' + a).children('.addr-err').html('Спершу завершіть редагування/додавання іншої адреси');
        return;
    }
    let data = await ajax('/ajax/profile/get', {
        'a': '1address',
        'id': a
    });
    data = data[0];
    console.log(data);
    $('#a' + a).fadeOut('fast');
    $('#ea-address').fadeIn('fast').data('action', 'edit');
    if (data.post_type == 'new') {
        $('.addr-o.focus').addClass('left');
        $("#new").prop('checked', true);
        $("#ua").prop('checked', false);
    } else {
        $('.addr-o.focus').removeClass('left');
        $("#new").prop('checked', false);
        $("#ua").prop('checked', true);
    }
    cityId = data.city;
    warehouseId = data.warehouse_id;
    addrId = data.id;
    $('#city-post').prop('disabled', true).val(data.city_desc).next('#pcity-err').html('Нажмiть дважди щоб змінити');
    $('#post-id').prop("disabled", true).val(data.place).next('#pid-err').html('Нажмiть дважди щоб змінити').parent().fadeIn('fast').parent().next().children().fadeIn('fast');
}

function addressDeleteConfirm(a) {
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
    <h3 class="fs15 fw400 mb24">Ви впевнені, що хочете видалити адресу?</h3>
    <div class="flex">
        <a onclick="addressDelete(${a}) " class="btn2 outline-btn mr12 pointer">Видалити</a>
        <a onclick="$('#overlay').fadeOut('fast',() => {$('#over-content').empty()})" class="btn2 azure-btn pointer">Залишити</a>
    </div>
</div>
    `)
    $('#overlay').fadeIn('fast');
    console.log(a);
}
async function addressDelete(id) {
    try {
        let data = await ajax('/ajax/profile/edit', {
            'a': 'deladdress',
            'id': id
        });
    } catch {
        if (ajaxErr.includes('wrong-user')) {
            $('#a' + id).children('.addr-err').html('Сталася помилка, будь ласка не грайтесь з кодом')
        } else if (ajaxErr.includes('too_many')) {
            $('#a' + id).children('.addr-err').html('Забагато адресiв, видалть не потрiбний');
        }
    }
    $('#overlay').fadeOut('fast');
    $('#over-content').empty();

    loadAddress();
}



let pos = {
    '0': 'name',
    '1': 'surname',
    '2': 'middlename',
    '3': 'email',
    '4': 'tel',
}


async function doAction() {
    let data = await ajax('/ajax/api/get', {
        'a': 'post',
        'post_type': postType,
        'req': req,
        'cityRef': req == 'id' ? cityId : '',
        'input': req == 'id' ? $('#post-id').val() : $('#city-post').val()
    });
    data = data.data;

    if (req == 'id') {
        if (data.length > 0) {
            data.forEach(x => {
                $('#ids-dropdown').append(`<a data-id="${x["Number"]}">${x["ShortAddress"]} Вiддiлення № ${x["Number"]}</a>`);
            })
            $('#ids-dropdown a').click(function () {
                timer = -1;
                warehouseId = $(this).data('id');
                $(this).parent().empty();
                $('#post-id').prop("disabled", true).val($(this).html());
                $('#pid-err').html('Нажмiть дважди щоб змінити');
                $('#post-save').fadeIn('fast').parent().fadeIn('fast');
            });
        } else {
            $('#pid-err').html('Нiчого не знайдено');
        }
    } else if (req == 'city') {
        data = data[0]["Addresses"];
        if (data.length > 0) {
            data.forEach(x => {
                $('#cities-dropdown').append(`<a data-ref="${x["DeliveryCity"]}">${x["Present"]}</a>`);
            })
            $('#cities-dropdown a').click(function () {
                cityId = $(this).data('ref');
                $(this).parent().empty().parent().next().fadeIn('fast');
                $('#post-id').prop("disabled", false);
                $('#city-post').prop("disabled", true).val($(this).html());
                $('#pcity-err').html('Нажмiть дважди щоб змінити');
            });
        } else {
            $('#pcity-err').html('Нiчого не знайдено');
        }

    }
}

function startAction() {
    if (timer > 0) {
        timer--;
        window.requestAnimationFrame(startAction);
    } else if (timer == 0) {
        doAction();
        timer = -1;
    }
}

async function SaveAddress() {
    if (warehouseId != -1 && cityId != -1) {
        if ($('#ea-address').data('action') == 'edit') {
            try {
                await ajax('/ajax/profile/edit', {
                    'a': 'editaddress',
                    'id': addrId,
                    'city': cityId,
                    'post': warehouseId,
                    'post_type': postType,
                    'action': $('#ea-address').data('action')
                });
            } catch {
                if (ajaxErr.includes('repeat')) {
                    $('#form-err').text('Не можна додавати однаковi адреси');
                    return;
                }
            }
        } else {
            try {
                await ajax('/ajax/profile/edit', {
                    'a': 'addaddress',
                    'city': cityId,
                    'post': warehouseId,
                    'post_type': postType,
                    'action': $('#ea-address').data('action')
                });
            } catch {
                if (ajaxErr.includes('repeat')) {
                    $('#form-err').text('Не можна додавати однаковi адреси');
                    return;
                }
            }
        }
        $('#ea-address').fadeOut('fast');
        $('#city-post').prop('disabled', false).val('').next('#pcity-err').text('').parent().next().children().first('#post-id').prop('disabled', false).val('').next('#pid-err').text('');
        loadAddress();
    }
}

function initDelay(action) {
    if (($('#post-id').val() != '' && action == 'id') || (action == 'city' && $('#city-post').val() != '')) {
        if ($('#new').is(':checked')) postType = 'new';
        else postType = 'ua';
        timer = 150;
        req = action;
        window.requestAnimationFrame(startAction);
    } else {
        timer = -1;
    }
}
