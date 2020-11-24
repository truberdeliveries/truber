<?php
include 'includes/session.php';
include 'includes/format.php';
?>
<?php
$today = date('Y-m-d');
$year = date('Y');
if(isset($_GET['year'])){
    $year = $_GET['year'];
}

$conn = $pdo->open();

$stmt = $conn->prepare("SELECT COUNT(*) AS num FROM booking where booking_status IN (3,4) AND cust_id=:cust_id");
$stmt->execute(['cust_id'=>$admin['id']]);
$rows = $stmt->fetch();


if($rows['num']>0){
    //header('location: home.php');
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="z-index: 9;background: #ecf0f5;">
            <h1>
                Accepted Ride
            </h1>
            <ol class="breadcrumb">
                <li><a href="./home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Accepted Ride</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" style="">
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

            <div class="row">
                <button class="face1" onclick="closeFace();" style="z-index: 9;position: relative;border: none"><< Hide</button>
                <button class="face2" onclick="openFace();" style="z-index: 9;position: relative;border: none" hidden>Show >></button>
                <div class="col-lg-6 col-xs-6 adjust">

                    <!-- small box -->
                    <?php
                    try{
                        $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_status IN (1,2) AND cust_id=:cust_id ");
                        $stmt->execute(['cust_id'=>$admin['id']]);
                        $drName = $stmt->fetch();

                        $stmt = $conn->prepare("SELECT * FROM driver WHERE id=:driver_id");
                        $stmt->execute(['driver_id'=>$drName['driver_id']]);
                        $row = $stmt->fetch();

                        $photo =(!empty($row['photo'])) ? './assets/img/photos/'.$row['photo'] : './../images/profile.png';

                        echo "<img src='.$photo.' width='300px' height='300px'>";

                        echo "<h2 style='color: green'> Your driver is ".$row['firstname']." ".$row['lastname']."</h2>";



                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }

                    ?>

                    <span id="mm">
                    <h3><strong id="ride-status" style="color: orange">Driver Is Heading Your Way ...</strong></h3><br/>
                    <button class="btn btn-primary" onclick="location.href='tel: <?php echo $row['mobile']?>'"><i class="fa fa-phone"></i>  Call</button>
                    <button class="btn btn-danger" id="<?php echo $drName['book_id']?>" ><i class="fa fa-close"></i>  Cancel</button>
                    <button class="look-up" id="<?php echo $drName['book_id']?>"  style="display: none">stats</button>
                        <input type="hidden" id="looks" value="<?php echo $drName['book_id']?>">
                    </span>
                    <span id="mm2">
                        <u><h3><i>Ride History</i></h3></u>
                        <strong><i>From: <?php echo $drName['start_address']?></i></strong><br/>
                        <strong><i>To: <?php echo $drName['end_address']?></i></strong><br/>
                        <strong class="duration"></strong><br/>
                        <span id="total-amount" class="total-amount">
                            <?php

                            try{
                                $stmt = $conn->prepare("SELECT * FROM invoice WHERE customer_id=:id ORDER BY date_created DESC ");
                                $stmt->execute(['id'=>$admin['id']]);
                                $row = $stmt->fetch();
                                echo 'Total Amount: R'. $row['amount'];
                            }
                            catch(PDOException $e){
                                echo $e->getMessage();
                            }
                            ?>
                        </span><br/>
                        <button class="btn btn-success done" onclick="clearSession();"><i class="fa fa-check-circle-o"></i> Done</button>
                    </span>

                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
                <?php

                try {
                    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_status=1 AND cust_id=:id");
                    $stmt->execute(['id'=>$admin['id']]);
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

            <input class="Fst1" value="<?php echo $lat;?>" hidden><input class="Fst2" value="<?php echo $long;?>" hidden>
            <input class="Sst1" value="<?php echo $lat2;?>" hidden><input class="Sst2" value="<?php echo $long2;?>" hidden>

            <div class="row">
                <div class="col-xs-12">

                    <div id="map" class="map"></div>
                    <script src="../maps/js/leaflet.js"></script>
                    <script src="../maps/js/leaflet-routing-machine.js"></script>
                    <script src="../maps/js/driverJs.js"></script>

                </div>
            </div>
    </div>

</body>
<!-- right col -->
</div>
<?php include 'includes/footer.php';  ?>
<?php include 'includes/users_modal.php'; ?>
<?php include 'includes/scripts.php'; ?>

</div>
<!-- ./wrapper -->

<script>
    $(function() {

        $(document).on('click', '.btn-danger', function(e){

            e.preventDefault();
            $('#cancel').modal('show');
            var id = this.id;
             getRow(id);
        });

        $(document).on('click', '.look-up', function(e) {

            $.ajax({
                type: 'POST',
                url: 'booking_row.php',
                data: {booking_id:this.id,
                    ride_check:1},
                dataType: 'json',
                success: function(response){

                    if(response.booking_status ==4){
                        $('#mm').html('<h3 style="color: red">Ride Cancelled, Redirecting to Home Page <i class="fa fa-spinner fa-spin"></i></h3>');
                        setTimeout(function (e){
                            location='home.php';
                        },5000);
                    }
                    if(response.booking_status == 2){
                        $('#ride-status').html('Driving To Destination ...');
                        $('.btn-danger').hide();
                        sessionStorage.setItem('start_time',1);

                    }


                    if(response.booking_status ==3){
                       finishedRide(response.book_id);
                    }
                }
            });

        });

    });

    function clearSession(){
        sessionStorage.clear();
        location='home.php';
    }

    function finishedRide(id){
        $('#total-amount').load(document.URL +  ' #total-amount');
        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {finish_id:id},
            dataType: 'json',
            success: function(data){
               // paid();
                sessionStorage.setItem('total_time',data.total_time);
                $('#mm').hide();
                $('.duration').html('Duration: '+sessionStorage.getItem('total_time'));
                $('#mm2').show();

            }
        });
    }

    function paid(){

        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {paid:1},
            dataType: 'json',
            success: function(response){

            }
        });
    }

    function getRow(id){

        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('#trip_id').val( response.book_id);
            }
        });
    }

    var myVar = setInterval(function() {
        checkStatus();
        checkLocation();

    }, 5000);


    function checkLocation(){
        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {id_check:1},
            dataType: 'json',
            success: function(response){
                var coord = response.driver_coord;
                var lat = coord.substr(0,coord.indexOf(','));
                coord = coord.replace(coord.substr(0,coord.indexOf(',')+1),'');
                var long = coord;

                var lat1 = $('.Fst1').val();
                var long1 = $('.Fst2').val();
                var lat2 = $('.Sst1').val();
                var long2 = $('.Sst2').val();

                setValues([lat,long],[lat1,long1],[lat2,long2]);
                $('.leaflet-shadow-pane img:first-child').attr('src','./../assets/img/truck.png');

            }
        });
    }

    function checkStatus(){
        $('.look-up').click();
    }
    if(sessionStorage.getItem('start_time') ==1){
        $('#ride-status').html('Driving To Destination ...');
        $('.btn-danger').hide();
    }


    if(sessionStorage.getItem('total_time')){
         $('.done').click();
    }

    function openFace(){
        $('.adjust').fadeIn(600);
        $('.face2').hide();
        $('.face1').show();
    }

    function closeFace(){
        $('.adjust').fadeOut(100);
        $('.face1').hide();
        $('.face2').show();
    }
</script>
<!-- Chart Data -->

<!-- End Chart Data -->

<?php $pdo->close(); ?>

<style>
    .inputContainer i {
        position: absolute;
    }
    .inputContainer {
        width: 100%;
        margin-bottom: 10px;
    }
    .icon {
        padding: 4px;
        padding-left: 8px;
        color: lightgrey;
        width: 80px;
        text-align: left;
    }
    .Field {
        text-align: center;
    }
</style>

