<header class="main-header">
  <!-- Logo -->
    <a class="back-btn" href="<?php echo $_SERVER['HTTP_REFERER'];?>">
        <i class="fa fa-arrow-circle-left"></i> Back</a>
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>T</b>B</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Truber</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu" onclick="shows();">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo (!empty($admin['photo'])) ? '../assets/img/photos/'.$admin['photo'] : '../images/profile.png'; ?>" class="user-image" >
            <span class="hidden-xs"><?php echo $admin['firstname'].' '.$admin['lastname']; ?><i>  [ Driver ]</i></span>
          </a>
          <ul class="dropdown-menu" id="dropdown-menu">
            <!-- User image -->
            <li class="user-header">

              <p>
                <?php echo $admin['firstname'].' '.$admin['lastname']; ?>
                <small>Member since <?php echo date('M. Y', strtotime($admin['date_registered'])); ?></small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="pull-right">
                <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<script>
    function shows()
    {
        var x = document.getElementById("dropdown-menu");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


</script>

<?php include 'includes/profile_modal.php'; ?>

