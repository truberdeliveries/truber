var myVar = setInterval(checkStatus, 5000);

function checkStatus(){
        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {},
            dataType: 'json',
            success: function(response){
                if(response.booking_status){
                   location = 'request_accepted.php';
                }
            }
        });
}