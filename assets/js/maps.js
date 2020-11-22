
var info;
var info2;

$(document).on('click', '.address-select', function(e){

    $('input[name=start]').val($(this).text());
    $('.all-info').hide();
    var setAdr = $(this).attr('name');
    var latitude = setAdr.substr(0, setAdr.indexOf(','));
    var longitude = setAdr.replace(latitude, '');
    longitude = longitude.replace(',', '');

    $('input[name=cord]').val(setAdr);

    sessionStorage.setItem('latitude',latitude);
    sessionStorage.setItem('longitude',longitude);

    $('input[name=destination]').attr('disabled',false);
});

$(document).on('click', '.address-select2', function(e){

    $('input[name=destination]').val($(this).text());
    $('.all-info2').hide();
    var setAdr = $(this).attr('name');
    var latitude = setAdr.substr(0, setAdr.indexOf(','));
    var longitude = setAdr.replace(latitude, '');
    longitude = longitude.replace(',', '');

    var concat = $('input[name=cord]').val()+'|'+setAdr;
    $('input[name=cord]').val(concat);

    if (sessionStorage.getItem('latitude') ==null && sessionStorage.getItem('longitude') ==null){
        clearSession();
        sessionStorage.setItem('latitude',latitude);
        sessionStorage.setItem('longitude',longitude);
    }else {
        setValues([sessionStorage.getItem('latitude'), sessionStorage.getItem('longitude')],[latitude,longitude]);
        //Distance Calculations
        getDistance([sessionStorage.getItem('latitude'), sessionStorage.getItem('longitude')],[latitude,longitude]);
    }

});


function getMap() {

    var address =$('input[name=start]').val();
    address= address.replaceAll(' ','%20');
    $.ajax({
        url: 'http://api.positionstack.com/v1/forward?access_key=1400d3585e01ac6b625cfaf163c50b7d&query='+address,
        dataType: 'json',
        data: {}
    }).done(function (data) {
        info =data.data;
        setCoordinates();

    }).fail(function (jqXHR, exception) {
        $('.all-info').html('');
        $('.all-info').html('<tr><td>Address Not Found !!!</td></tr>');
    });
    $('.all-info').show();
}
function getMap2() {

    var address =$('input[name=destination]').val();
    address= address.replaceAll(' ','%20');
    $.ajax({
        url: 'http://api.positionstack.com/v1/forward?access_key=1400d3585e01ac6b625cfaf163c50b7d&query='+address,
        dataType: 'json',
        data: {}
    }).done(function (data) {
        info2 =data.data;
        setCoordinates2();

    }).fail(function (jqXHR, exception) {
        $('.all-info2').html('');
        $('.all-info2').html('<tr><td>Address Not Found !!!</td></tr>');
    });
    $('.all-info2').show();
}

function setCoordinates() {
    $('.all-info').html('');
    if(info[0].label ==undefined) {

        $('.all-info').html('<tr><td>Address Not Found !!!</td></tr>');
    }else{
        for(var i=0;i< info.length;i++){

            $('.all-info').append('<tr><td class="address-select" name="'+info[i].latitude+','+info[i].longitude+'">'+info[i].label+'</td></tr>');
        }
    }

}

function setCoordinates2() {
    $('.all-info2').html('');
    if(info2[0].label ==undefined) {

        $('.all-info2').html('<tr><td>Address Not Found !!!</td></tr>');
    }else{
        for(var i=0;i< info2.length;i++){

            $('.all-info2').append('<tr><td class="address-select2" name="'+info2[i].latitude+','+info2[i].longitude+'">'+info2[i].label+'</td></tr>');
        }
    }

}

function request_confirmed(){

    var input = $('input[name=cord]').val();
    if(!input || input.indexOf('|') == -1){
       $('.error-adr').html('Ensure both addresses are valid ...');
       return false;
    }

    requestBalance();
    return false;
}
function getDistance(dFrom,dTo){

    var from = turf.point([dFrom[0],dFrom[1]]);
    var to = turf.point([dTo[0], dTo[1]]);
    var options = {units: 'kilometers'};

    var distance = turf.distance(from, to, options);

    distance= distance+0.45;
    distance = distance.toFixed(1);

    $('.trip-distance').val(distance);
}

function clearSession(){
    sessionStorage.clear();
}
clearSession();