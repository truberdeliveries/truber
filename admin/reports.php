<?php include 'includes/session.php'; ?>
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
          Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
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


      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              
              <div class="pull-right">
                  <div class="form-group">
                     <label for="type" class="col-sm-3 control-label">Report Type</label>

                      <div class="col-sm-9">
                          <select name="type" id="type" class="form-control" required>
                              <option selected disabled>Select report type</option>
                              <option value="Veh">Vehicle</option>
                              <option value="cust">Customers</option>
                              <option value="driv">Drivers</option>
                              <option value="trips">Trips</option>
                              <option value="members">New Members</option>
                          </select>
                      </div>
                  </div>

              </div>
            </div>


              <div style="padding-left: 30%;">
                  <div class="input-group">
                      Start Date: <span class="fromdate"><span class="fa fa-calendar-times-o"></span></span>
                      <input type="date" name="fromD" class="form-control" placeholder="Date" required />
                  <br/>
                      End Date: <span class="todate"><span class="fa fa-calendar-times-o"></span></span>
                      <input type="date" name="toD" class="form-control" placeholder="Date" required />
                  </div>
                  <br/>
                  <span class="date-error"></span><br/>
                  <input type="button" name="generate" class="btn btn-success" value="Generate Report" onclick="generateRep()">
              </div>
<!--              -->
            <div id="drivers-report" class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Customer Name</th>
                  <th>Driver Name</th>
                  <th>Pick Up</th>
                  <th>Destination</th>
                  <th>Date</th>
                </thead>
                <tbody >

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){


    $(document).on('click', '.addnew', function(e){

        e.preventDefault();
        $('#addnew').modal('show');
        var id = e.target.parentNode.id;
        getRow(id);
    });

    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        $('#edit').modal('show');
        var id = e.target.parentNode.id;
        getRow(id);
    });

    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        $('#delete').modal('show');
        var id = e.target.parentNode.id;
        getRow(id);
    });

    $(document).on('click', '.photo', function(e){
        e.preventDefault();
        var id = e.target.parentNode.id;
        getRow(id);
    });

    $(document).on('click', '.status', function(e){
        e.preventDefault();
        var id = e.target.parentNode.id;
        getRow(id);
    });


});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'drivers_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('#edit_email').val(response.email);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#edit_contact').val(response.contact_info);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
<script>
    $(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  //Date range picker
  $('#reservation').daterangepicker()
  //Date range picker with time picker
  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  )

});

</script>
<script type="application/javascript" src="../assets/js/report.js"></script>
</body>
</html>
