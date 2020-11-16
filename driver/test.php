
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
    <div class="content-wrapper" style="background: none">
        <!-- Content Header (Page header) -->
        <section class="content-header">
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
                <div class="col-lg-13">

                    <img src="./../images/profile.png" width="300px" height="300px">
                    <!-- small box -->
                    <?php
                    try{
                        $stmt = $conn->prepare("SELECT * FROM booking WHERE driver_name=:driver_name AND booking_status=1");
                        $stmt->execute(['driver_name'=>$admin['email']]);
                        $cName = $stmt->fetch();

                        $stmt = $conn->prepare("SELECT firstname,lastname,mobile FROM customer WHERE email=:email");
                        $stmt->execute(['email'=>$cName['customer_name']]);
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
                        <span class="total">Total Amount: R255</span><br/>
                        <button class="btn btn-success" onclick="clearSession();"><i class="fa fa-check-circle-o"></i> Done</button>
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
                    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_status=1 AND driver_name=:name");
                    $stmt->execute(['name'=>$admin['email']]);
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
            <script src="./rides/maps/js/leaflet.js"></script>
            <script src="./rides/maps/js/leaflet-routing-machine.js"></script>
            <script src="./rides/maps/js/index.js"></script>
            <script src='./rides/maps/js/turf.min.js'></script>
            <script>
                var from = turf.point([-25.754264,28.195877]);
                var to = turf.point([-25.74868, 28.19539]);
                var options = {units: 'kilometers'};

                var distance = turf.distance(from, to, options);
                //console.log(callValues());
                setValues([-25.754264,28.195877],[-25.74868, 28.195804]);
            </script>
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
            changeMaps();

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

        // $('#mm3').html('<h3 style="color: red">Ride Cancelled, Redirecting to Available Rides <i class="fa fa-spinner fa-spin"></i></h3>');
        // setTimeout(function (e){
        //     location='available_rides.php';
        // },5000);

    }

    var myVar = setInterval(checkStatus, 5000);

    function checkStatus(){
        $('.look-up').click();
    }

    getStart();

    function changeMaps() {
        if (sessionStorage.getItem('start_time') == 1) {
            $('#maps-view').hide();
            $('#maps-view2').show();
        }
    }
    changeMaps();
</script>
<!-- Chart Data -->

<!-- End Chart Data -->

<?php $pdo->close(); ?>

<script>
    $(function(){
        $('#select_year').change(function(){
            window.location.href = 'home.php?year='+$(this).val();
        });
    });

    // function loadMap()
    // {
    //     var lat = $('.Fst1').val();
    //     var long = $('.Fst2').val();
    //     var lat2 = $('.Sst1').val();
    //     var long2 = $('.Sst2').val();
    //
    //     function getLocation() {
    //         if (navigator.geolocation) {
    //             navigator.geolocation.getCurrentPosition(showPosition);
    //         } else {
    //             alert("Geolocation is not supported by this browser.");
    //         }
    //     }
    //
    //     function showPosition(position) {
    //         setValues([position.coords.latitude,position.coords.longitude],[lat,long],[lat2,long2]);
    //     }
    //
    //     getLocation();
    //
    // }
    // loadMap();

</script>
</body>
</html>
