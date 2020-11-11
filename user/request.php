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

$stmt = $conn->prepare("SELECT COUNT(*) AS num FROM booking where booking_status=1 AND customer_name=:email");
$stmt->execute(['email'=>$admin['email']]);
$rows = $stmt->fetch();


if($rows['num']>0){
    header('location: request_accepted.php');
}

    $conn = $pdo->open();
?>
<?php include 'includes/header.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="z-index: 9;background: #ecf0f5">
                <h1>
                    Request Truber
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Request Truber</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content" style="padding-top: 0">
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

                <?php
                try{
                    $email = $admin['email'];
                    $requested = null;
                    $stmt = $conn->prepare("SELECT booking_status FROM booking WHERE customer_name =:email AND booking_status=0");
                    $stmt->execute(['email'=>$email]);
                    $row = $stmt->fetch();
                    $requested = $row['booking_status'];

                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }


                if($requested == null){

                echo '

                <div class="row">
                    <div class="col-lg-6 col-xs-6 adjust">
                        <!-- small box -->
                        <form class="form" method="POST" action="handle_requests.php">
                            <div class="inputContainer">
                                <i class="fa fa-money fa-2x icon"> </i>

                            <select class="form-control Field" style="text-align-last:center;" name="payment" onchange="selectCard(this.value);"  required >
                                <option value="" selected disabled hidden>Choose Payment Type</option>
                                <option value="cash">Cash</option>
                                
                                ';

                                    try{
                                        $stmts = $conn->prepare("SELECT * FROM card WHERE id=:id");
                                        $stmts->execute(['id'=>$admin['id']]);

                                        if(empty($stmts)){
                                            echo' <option value="card">Card</option>';
                                        }else{
                                            foreach($stmts as $row){

                                                echo "<option style='background:lightgrey' value=".$row['cardnumber'].">".$row['cardnumber']."</option>";
                                            }
                                            echo' <option value="card"></i>Add New Card</option>';
                                        }
                                    }
                                    catch(PDOException $e){
                                        echo $e->getMessage();
                                    }

                                echo'
                               
                            </select>
                            </div>
                            <br/>

                            <div class="inputContainer">
                                <i class="fa fa-cab fa-2x icon"> </i>

                                <select class="form-control Field" style="text-align-last:center;" name="type" onchange="selectVehicle(this.value);" required >
                                    <option value="" selected disabled>Choose Vehicle Type</option>
                   ';

                                    try{
                                        $stmt = $conn->prepare("SELECT * FROM type ");
                                        $stmt->execute();
                                        foreach($stmt as $row){

                                            echo "<option value=".$row['image'].">".$row['name']."</option>";
                                        }
                                    }
                                    catch(PDOException $e){
                                        echo $e->getMessage();
                                    }

                                echo '
                                </select><br/>
                                <img name="vehicles" width="250" hidden>
                            </div>
                            <br/>

                            <div class="inputContainer">
                            <i class="fa fa-street-view fa-2x icon"> </i>
                            <input class="form-control Field" type="text" id="inputEmail" required="" placeholder="Pick-Up Address" autofocus="" name="start" onkeydown="getMap()">
                             <table class="all-info"></table>
                        </div>
                            <br/>
                        <div class="inputContainer">
                            <i class="fa fa-map-marker fa-2x icon"> </i>
                            <input class="form-control Field" type="text" id="inputEmail" required="" placeholder="Destination Address" autofocus="" name="destination" onkeydown="getMap2()">
                               <table class="all-info2"></table>
                        </div>
                       <input name="cord" hidden> 
                            <button class="btn btn-primary btn-block btn-lg btn-signin" name="request" type="submit">Request</button>
                        </form>

                    </div>
                ';
                }
                else{
                    echo '
                      <h3>Please wait while we look for your driver <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                        <span class="sr-only">Loading...</span></h3>
                      ';
                }
                ?>
                    <!-- ./col -->
                </div>
                <br/>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12">

                        <div id="map" class="map"></div>
                        <script src="../maps/js/leaflet.js"></script>
                        <script src="../maps/js/leaflet-routing-machine.js"></script>
                        <script src="../maps/js/index.js"></script>
                        <script src='../maps/js/turf.min.js'></script>

                    </div>
                </div>
        </div>

        </body>
        <!-- right col -->
    </div>
<?php include 'includes/footer.php'; ?>

    </div>
    <!-- Modal -->
<!-- Activate -->
<div class="modal fade" id="addcard">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Bank Card...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="booking_row.php" onsubmit="return validateCard();">
                    <input type="hidden" class="userid" name="banking-details" hidden>

                    <div class="text-center">
                        <label for="card-number">Card Number</label>
                        <input  class="form-control" name="card-number" id="card-number" onkeypress="return /[0-9]/i.test(event.key);" onkeyup="enterCard()" required>
                        <span id="card-error" style="color: red"></span>
                    </div><br/>
                    <div class="text-center">
                        <label for="name">Bank Name</label>
                        <select class="form-control" name="name" id="bank" onchange="setBranch(this.id);enterCard()" required>
                            <option value="" disabled selected hidden>Select Bank</option>
                            <option id="470010" value="capitec">Capitec</option>
                            <option id="250655" value="fnb">FNB</option>
                            <option id="632005" value="absa">ABSA</option>
                            <option id="051001" value="standard-bank">Standard Bank</option>
                            <option id="198765" value="nedbank">Nedbank</option>
                        </select>
                    </div><br/>
                    <div class="text-center">
                        <label for="branch">Branch Code</label>
                        <input class="form-control" name="branch" id="branch" onkeypress="return /[0-9]/i.test(event.key)" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="activate"><i class="fa fa-check"></i> Add Card</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Chart Data -->

    <!-- End Chart Data -->

<?php $pdo->close(); ?>
<?php include 'includes/scripts.php'; ?>

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

<script type="application/javascript">
    var myVar = setInterval(checkStatus, 5000);

    function checkStatus(){
        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {id_check:1},
            dataType: 'json',
            success: function(response){
                if(response.booking_status){
                    location = 'request_accepted.php';
                }
            }
        });
    }

    function selectVehicle(name){
        $('img[name=vehicles]').attr('src','./../assets/img/vehicles/'+name);
        $('img[name=vehicles]').show();
    }

    function selectCard(name){

        if(name =='card')
        {
            $('#addcard').modal('show');
        }
    }
    function setBranch(){

        $('#branch').val($('#bank option:selected').attr('id'));
       // $('#branch').attr('disabled','disabled');
    }

    function enterCard(){

        var num = $('#card-number').val();
        var bank = $('#bank').val();
        $.ajax({
            type: 'POST',
            url: 'booking_row.php',
            data: {check_card:num,
            bank:bank},
            dataType: 'json',
            success: function(response){
                if(response !=false){
                    $('#card-error').html('Card Already Exists !!!');
                }
                else{
                    $('#card-error').html('');
                }
            }
        });
    }

    function validateCard(){
        if($('#card-error').html !='' ){
            $('#card-number').focus();
            return false;
        }
        return true;
    }
</script>

<script src="./../assets/js/maps.js"></script>

