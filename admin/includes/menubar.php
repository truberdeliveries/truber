<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <br>
        <br>
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
        <br>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">WELCOME</li>
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MANAGE</li>
      <li><a href="users.php"><i class="fa fa-users"></i> <span>Customers</span></a></li>
      <li><a href="drivers.php"><i class="fa fa-users"></i> <span>Drivers</span></a></li>
      <li><a href="vehicles.php"><i class="fa fa-car"></i> <span>Vehicles</span></a></li>
        <li><a href="reports.php"><i class="fa fa-file"></i> <span>Reports</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>