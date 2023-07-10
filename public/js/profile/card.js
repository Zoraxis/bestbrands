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

function addCard() {
    $('#over-content').html(`<div id="card-add-ov">
    <div class="row mb24">
        <h2 class="fs18 fw500">Додати платіжну карту</h2>
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
    <div class="inputs">
        <div class="input">
            <label class="fw400 fs15" for="cnum">Номер карти</label>
            <input placeholder="0000 0000 0000 0000" type="text" id="cnum">
        </div>
        <div class="input">
            <label class="fw400 fs15" for="cname">Ім’я на карті</label>
            <input type="text" id="cname">
        </div>
        <div class="input">
            <label class="fw400 fs15" for="exdate">Термін придатності</label>
            <input type="date" id="exdate">
        </div>
    </div>
    <a class="btn fill-btn fix-btn" id="add-card-conf">Додати</a>
    <span id="add-card-error"></span>
</div>
    `);
    $('#overlay').fadeIn('fast');
    $('#add-card-conf').click(function () {
        // $('#overlay').fadeOut('fast',() => {$('#over-content').empty()})
        if($('#exdate').val() != undefined && $('#cnum').val() != '' && $('#cname').val() != '') {
            $.ajax({
                'url': '/ajax/profile/edit',
                'type': 'GET',
                'dataType': 'json',
                'data': {
                    'a': 'addcard',
                    'exdate': $('#exdate').val(),
                    'name': $('#cname').val(),
                    'cnum': $('#cnum').val(),
                },
                'success': function (data) {
                    loadCards();
                },
                'error': function(data, status, error){
                    if(data.responseText.includes('empty')){
                        $('#add-card-error').text('Усi поля мають бути заповненими')
                    }
                    else console.log(data.responseText);
                    loadCards();
                    $('#overlay').fadeOut('fast', function(){
                        $('#over-content').detach();
                    });
                }
            });
        }
    });
}

function CardDel(id){
    let data = ajax('/ajax/profile/edit', {
        'a': 'delcard',
        'id': id
    });
    loadCards();
    $('#overlay').fadeOut('fast', function(){
        $('#over-content').detach();
    });
}
