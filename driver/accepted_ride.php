
<?php
include './includes/session.php';
include './includes/format.php';
?>
<?php
$today = date('Y-m-d');
$year = date('Y');
if(isset($_GET['year'])){
    $year = $_GET['year'];
}

$conn = $pdo->open();

$stmt = $conn->prepare("SELECT COUNT(*) AS num FROM booking where booking_status IN (3,4) AND driver_id=:driver_id");
$stmt->execute(['driver_id'=>$admin['id']]);
$rows = $stmt->fetch();


if($rows['num']>0){
    header('location: available_rides.php');
}
?>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="./rides/maps/dist/leaflet.css" />
<link rel="stylesheet" href="./rides/maps/dist/leaflet-routing-machine.css" />
<link rel="stylesheet" href="./rides/maps/dist/index.css" />
<style>
    .leaflet-marker-icon{
        display: none;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include './includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background: #ecf0f5; z-index: 9;">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="background: #ecf0f5;z-index: 9">
            <h1>
                Accepted Ride
            </h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"> Accepted Ride</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" style="position: absolute;background: #ecf0f5;z-index: 9">
            <?php
            if(isset($_SESSION['error'])){
                echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
                echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
                unset($_SESSION['success']);
            }
            ?>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-13 " style="padding: 10px;">

                    <img src="./../images/profile.png" width="300px" height="300px">
                    <!-- small box -->
                    <?php
                    try{
                        $stmt = $conn->prepare("SELECT * FROM booking WHERE driver_id=:driver_id AND booking_status=1");
                        $stmt->execute(['driver_id'=>$_SESSION['driver']]);
                        $cName = $stmt->fetch();

                        $stmt = $conn->prepare("SELECT * FROM customer WHERE id=:id");
                        $stmt->execute(['id'=>$cName['cust_id']]);
                        $row = $stmt->fetch();

                        echo "<h2 style='color: green'>Customer name is ".$row['firstname'].' '.$row['lastname']."</h2>";


                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }

                    ?>
                    <span id="mm">
                    <h3><strong id="ride-status" style="color: orange">Picking Up Customer ...</strong></h3><br/>
                    <button class="btn btn-primary" onclick="location.href='tel: <?php echo $row['mobile']?>'"><i class="fa fa-phone"></i>  Call</button><br/><br/>
                    <button class="btn btn-warning start" id="<?php echo $cName['book_id']?>" ><i class="fa fa-street-view"></i>  Picked-Up</button>
                    <button class="btn btn-success rideBtn" id="<?php echo $cName['book_id']?>"><i class="fa fa-check"></i>  Finished</button>
                    <button class="btn btn-danger" id="<?php echo $cName['book_id']?>" ><i class="fa fa-close"></i>  Cancel</button>
                    </span>
                    <span id="mm2">

                        <u><h3><i>Ride History</i></h3></u>
                        <strong><i>From: <?php echo $cName['start_address']?></i></strong><br/>
                        <strong><i>To: <?php echo $cName['end_address']?></i></strong><br/>
                        <strong class="duration"></strong><br/>
                        <span class="total-amount"></span><br/>
                        <button class="btn btn-success done" onclick="clearSession();"><i class="fa fa-check-circle-o"></i> Done</button>

                    </span>
                    <span id="mm3"></span>
                </div>
                <input name="book_id" id="book_id" hidden>
            </div><br/>
        </section>
        <section>
            <div class="row">
                <?php

                try {
                    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_status=1 AND driver_id=:id");
                    $stmt->execute(['id'=>$_SESSION['driver']]);
                    $row = $stmt->fetch();
                    $row = $row["coordinates"];
                    $row1 = substr($row, 0, strpos($row,'|'));
                    $lat = substr($row1,0,strpos($row1,','));
                    $long = substr($row1, strpos($row1,',')+1);

                    $row2 = substr($row, strpos($row,'|'));
                    $lat2 = substr($row2,1,strpos($row2,',')-1);
                    $long2 = substr($row2, strpos($row2,',')+1);

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
            </div>


            <input class="Fst1" value="<?php echo $lat;?>" hidden><input class="Fst2" value="<?php echo $long;?>" hidden>
            <input class="Sst1" value="<?php echo $lat2;?>" hidden><input class="Sst2" value="<?php echo $long2;?>" hidden>

            <div id="map" class="map"></div>
            <script src="./../maps/js/leaflet.js"></script>
            <script src="./../maps/js/leaflet-routing-machine.js"></script>
            <script src="./../maps/js/driverJs.js"></script>

    </div>

</div>

</section>
<!-- right col -->
</div>
<button class="look-up" id="<?php echo $cName['book_id']?>"  style="display: none">stats</button>
<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->
<?php include 'rides/rides_modal.php'; ?>
<?php include 'includes/scripts.php'; ?>
<script>
    $(function(){

        $(document).on('click', '.start', function(e){

            e.preventDefault();

            var id = this.id;
            updateRecord(id);

        });
        $(document).on('click', '.rideBtn', function(e){

            e.preventDefault();

            var id = this.id;
            finishRecord(id);
        });

        $(document).on('click', '.btn-danger', function(e){

            e.preventDefault();
            $('#cancel').modal('show');
            var id = this.id;
            getRow(id);
        });

        $(document).on('click', '.look-up', function(e) {
            $.ajax({
                type: 'POST',
                url: 'rides_row.php',
                data: {id:this.id},
                dataType: 'json',
                success: function(response){

                    if(response.booking_status ==4){
                        $('#mm').hide();
                        $('#mm3').html('<h3 style="color: red">Ride Cancelled, Redirecting to Available Rides <i class="fa fa-spinner fa-spin"></i></h3>');
                        setTimeout(function (e){
                            location='available_rides.php';
                        },5000);
                    }
                }
            });

        });

    });
    function clearSession(){
        sessionStorage.clear();
        location='home.php';
    }
    function getRow(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('#trip_id').val( response.book_id);
            }
        });
    }

    function getStart(){
        if(sessionStorage.getItem('start_time') ==1){
            $('.start').hide();
            $('.btn-danger').hide();
            $('.rideBtn').show();
            $('#ride-status').html('Driving To Destination ...');
        }

        if(sessionStorage.getItem('end_time') ==1){
            $('#mm').hide();
            $('.duration').html('Duration: '+sessionStorage.getItem('total_time'));
            $('#mm2').show();
        }
    }

    function updateRecord(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {booking_id:id,
                pick_up:1},
            dataType: 'json',
            success: function(response){

                if(response.start_time != '00:00:00'){
                    sessionStorage.setItem('start_time',1 );
                }
                getStart();
            }
        });
    }
    function finishRecord(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {booking_id:id,
                finish:1},
            dataType: 'json',
            success: function(response){

                sessionStorage.setItem('end_time',1 );
                sessionStorage.setItem('total_time',response.total_time);

                getStart();
                totals(id);
            }
        });


    }
    function cancelRecord(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {booking_id:id,
                cancelled:1},
            dataType: 'json',
            success: function(response){
            }
        });

    }

    function totals(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {totals:id},
            dataType: 'json',
            success: function(response){

                var setAdr = response.coordinates;
                var first = setAdr.substr(0,setAdr.indexOf('|'));
                var latitude = first.substr(0, first.indexOf(','));
                var longitude = first.replace(latitude, '');
                longitude = longitude.replace(',', '');

                setAdr= setAdr.replace(setAdr.substr(0,setAdr.indexOf('|')+1),'');
                var latitude1 = setAdr.substr(0, setAdr.indexOf(','));
                var longitude1 = setAdr.replace(latitude1, '');
                longitude1 = longitude1.replace(',', '');

                var distance = getDistance([latitude,longitude],[latitude1,longitude1]);
                var base_price = response.base_price;
                var price_per_km  = response.price_per_km;
                var total;
                if(distance < 1){
                    total = Math.floor(base_price);
                }else{
                    total = Math.floor(parseFloat(base_price) + parseFloat((price_per_km*distance)));
                }

                response['amount'] = total;
                response['distance'] = distance;
                invoice(response);
            }
        });

    }

    function invoice(total){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {invoice:total,
            customer_id:total.cust_id,
            driver_id:total.driver_id,
            amount:total.amount,
            distance:total.distance,
            vehicle_type:total.name},
            dataType: 'json',
            success: function(response){


            }
        });
        $('.total-amount').html('Total Amount: R'+total.amount);
    }

    function getDistance(dFrom,dTo){

        var from = turf.point([dFrom[0],dFrom[1]]);
        var to = turf.point([dTo[0], dTo[1]]);
        var options = {units: 'kilometers'};

        var distance = turf.distance(from, to, options);

        distance= distance+0.45;
        distance = distance.toFixed(1);

        return distance;
    }

    var myVar = setInterval(function() {
        checkStatus();
        getLocation();
    }, 5000);

    function checkStatus(){
        $('.look-up').click();
    }

    getStart();


    $(function(){
        $('#select_year').change(function(){
            window.location.href = 'home.php?year='+$(this).val();
        });
    });


    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var lat = $('.Fst1').val();
        var long = $('.Fst2').val();
        var lat2 = $('.Sst1').val();
        var long2 = $('.Sst2').val();

        var values = position.coords.latitude+','+position.coords.longitude;
        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {map_id:1,
                values:values},
            dataType: 'json',
            success: function(response){
            }
        });

        setValues([position.coords.latitude,position.coords.longitude],[lat,long],[lat2,long2]);
        $('.leaflet-shadow-pane img:first-child').attr('src','./../assets/img/truck.png');
    }

    getLocation();

    if(sessionStorage.getItem('total_time')){
        $('.done').click();
    }


</script>
<script src='../maps/js/turf.min.js'></script>
<?php $pdo->close(); ?>
</body>
</html>
