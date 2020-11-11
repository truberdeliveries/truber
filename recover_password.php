<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Truber</title>
    <meta name="description" content="The system will allow the user to register online, then the information of the user will be validated. After registration the user will be allowed to login into the system. The user will then be allowed to choose the kind of truck she/he want to use, then the user will be required to enter the current location of his/her staff and destination location.">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kaushan+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/beautiful-dismissable-alert.css">
    <link rel="stylesheet" href="assets/css/Button-Outlines---Pretty.css">
    <link rel="stylesheet" href="assets/css/Google-Style-Login.css">
    <link rel="stylesheet" href="assets/css/top-alert-ie-E-Mail-Confirmation.css">
    <link rel="apple-touch-icon" href="images/delivery-van.jpg">

</head>

<body id="page-top">

<?php include 'includes/session.php'; ?>
<?php
  if(isset($_SESSION['user'])){
    header('location: user/home.php');
  }
?>
<?php include 'includes/navbar.php';?>
    <header class="masthead" style="background-image:url('assets/img/header-bg.jpg');">
        <div class="container">
            <div class="intro-text">
            <?php
                    if(isset($_SESSION['error'])){
                        echo "
                        <div class='alert alert-warning beautiful' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                           ".$_SESSION['error']."</div>
                        ";
                        unset($_SESSION['error']);
                    }

                    if(isset($_SESSION['success'])){
                        echo "
                        <div class='alert alert-warning beautiful' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                           ".$_SESSION['success']."</div>
                        ";
                        unset($_SESSION['success']);
                    }
                    ?>

                <div class="intro-lead-in"></div>
                <div class="login-card"><img class="profile-img-card" src="assets/img/avatar_2x.png">
                    <p class="profile-name-card"> </p>
                    <form class="form-signin" method="POST" action="verify.php"><span class="reauth-email"> </span>
                        <div class="form-group"><label for="email">Enter Recovery Email&nbsp;</label>
                            <input class="form-control" type="email" id="email" name="email" onkeyup="emailValidate('register')" required></div>
                        <input name="remember" hidden>
                        <button class="btn btn-primary btn-block btn-lg btn-signin" name="remember" type="submit">Submit</button>
                    </form>
                </div>
            <div class="intro-heading text-uppercase"></div>
        </div>
        </div>
    </header>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4"><span class="copyright">Copyright&nbsp;© Truber 2020</span></div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/agency.js"></script>
<script src="assets/js/main.js"></script>
    <script type="application/javascript" src="assets/js/main.js"></script>
</body>

</html>