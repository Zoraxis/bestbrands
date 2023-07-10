let ajaxErr;
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
            ajaxErr = xhr.responseText
            return xhr.responseText;
        }
    });
}

let szimg;
(function ($) {
    $(function () {
        $('#new-sz').click(function () {
            $('#sz-add').fadeIn();
        });
        $('#image').on('change', function (e) {
            if ($(this).val() == '') return;
            console.log($('#sz-img')[0]);
            var fd = new FormData($('#sz-img')[0]);
            fd.append('file', $('#sz-img')[0]);

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
                    $('#sz-img-status').text(data);
                    $("#image").val('');
                    img = data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText)
                }
            });
            e.preventDefault();
            return false;
        });
    });
}(jQuery));

let data, dest;
async function loadSizes() {
    try {
        await ajax('/ajax/profile/get', {
            'a': 'brands'
        });
        dest = $('#brand-sz').empty();
        exdata.forEach(x => {
            dest.append(`<option value="${x.id}">${x.name}</option>`);
        });
        let brands = exdata;

        await ajax('/ajax/profile/get', {
            'a': 'sizegrids'
        });
        $('#psizes').children('.size-grid').detach();
        dest = $('#psizes');
        exdata.forEach(x => {
            dest.append(`
        <div class="properties content-box size-grid">
            <div class="fw400 fs24">${x.name}</div>
            <div class="fw400 fs16">${brands.find(x=>x.id = x.brand_id).name}</div>
            <img src="${x.image}"/>
        </div>
    `);
        });
    } catch {
        console.log(ajaxErr);
    }

}

async function addSizeGrid() {
    try {
        await ajax('/ajax/general/set', {
            'a': 'addsizegrid',
            'img': szimg,
            'name': $('#sz-name').val(),
            'brand_id': $('#brand-sz').find(":selected").val()
        });
    } catch {
        console.log(ajaxErr);
    }
    if (ajaxErr.includes('empty')) {
        $('#sz-add-err').text('не можна залишате будь-яке поле пустим');
    }
    loadSizes();
}
