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
            <section class="content-header">
                <h1>
                    Request Truber
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Request Truber</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
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

                <div class="row" style="padding-top: 50px">
                    <div class="col-lg-6 col-xs-6">
                        <!-- small box -->
                        <form class="form" method="POST" action="handle_requests.php">
                            <div class="inputContainer">
                                <i class="fa fa-money fa-2x icon"> </i>

                            <select class="form-control Field" style="text-align-last:center;" name="payment" required >
                                <option value="" selected disabled hidden>Choose Payment Type</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                            </select>
                            </div>
                            <br/>

                            <div class="inputContainer">
                                <i class="fa fa-cab fa-2x icon"> </i>

                                <select class="form-control Field" style="text-align-last:center;" name="type" required >
                                    <option value="" selected disabled>Choose Vehicle Type</option>
                   ';

                                    try{
                                        $stmt = $conn->prepare("SELECT * FROM type ");
                                        $stmt->execute();
                                        foreach($stmt as $row){

                                            echo "<option value=".$row['name'].">".$row['name']."</option>";
                                        }
                                    }
                                    catch(PDOException $e){
                                        echo $e->getMessage();
                                    }

                                echo '
                                </select>
                            </div>
                            <br/>

                            <div class="inputContainer">
                            <i class="fa fa-street-view fa-2x icon"> </i>
                            <input class="form-control Field" type="text" id="inputEmail" required="" placeholder="Pick-Up Address" autofocus="" name="start">
                        </div>
                            <br/>
                        <div class="inputContainer">
                            <i class="fa fa-map-marker fa-2x icon"> </i>
                            <input class="form-control Field" type="text" id="inputEmail" required="" placeholder="Destination Address" autofocus="" name="destination">
                        </div>
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
                        <!-- Select vehicle -->

                    </div>
                </div>
        </div>

        </body>
        <!-- right col -->
    </div>
<?php include 'includes/footer.php'; ?>

    </div>
    <!-- ./wrapper -->

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
</script>

