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

                <!-- Small boxes (Stat box) -->
                <div class="row" style="padding-top: 50px">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <form class="form-signin" method="POST" action="verify.php">
                        <div class="inputContainer">
                            <i class="fa fa-street-view fa-2x icon"> </i>
                            <input class="form-control Field" type="email" id="inputEmail" required="" placeholder="Pick-Up Address" autofocus="" name="email">
                        </div>
                            <br/>
                        <div class="inputContainer">
                            <i class="fa fa-map-marker fa-2x icon"> </i>
                            <input class="form-control Field" type="email" id="inputEmail" required="" placeholder="Destination Address" autofocus="" name="email">
                        </div>
                            <button class="btn btn-primary btn-block btn-lg btn-signin" name="login" type="submit">Request</button>
                        </form>

                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12">
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
        padding: 10px;
        text-align: center;
    }
</style>

