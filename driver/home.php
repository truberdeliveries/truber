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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
      <div class="row">
          <div class="col-lg-3 col-xs-15">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
            
              
                <p>Go Online</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="available_rides.php" class="small-box-footer">Go Online <i class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>
       </div>

       <div class="row">
          <div class="col-lg-3 col-xs-15">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
            
              
                <p>View Vehicle</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
              <a href="vehicles.php" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i>

                <a href="#" class="small-box-footer addnew">Add <i class="fa fa-plus-square-o"></i></a></a>
            </div>

          </div>
       </div>

       <div class="row">
          <div class="col-lg-3 col-xs-15">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
            
              
                <p>View All Rides</p>
              </div>
              <div class="icon">
                <i class="fa fa-search-plus"></i>
              </div>
              <a href="#" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>
       </div>
  
  
  
      </div>

      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<?php include 'includes/vehicles_modal.php'; ?>
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
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.delete', function(e){
            e.preventDefault();
            $('#delete').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.photo', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.status', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            getRow(id);
        });

    });

    function getRow(id){
        $.ajax({
            type: 'POST',
            url: 'users_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('.userid').val(response.id);
                $('#edit_email').val(response.email);
                $('#edit_password').val(response.password);
                $('#edit_firstname').val(response.firstname);
                $('#edit_lastname').val(response.lastname);
                $('#edit_address').val(response.address);
                $('#edit_mobile').val(response.mobile_info);
                $('.fullname').html(response.firstname+' '+response.lastname);
            }
        });
    }
</script>
<!-- Chart Data -->

<!-- End Chart Data -->

<?php $pdo->close(); ?>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChart = new Chart(barChartCanvas)
  var barChartData = {
    labels  : <?php echo $months; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $sales; ?>
      }
    ]
  }
  //barChartData.datasets[1].fillColor   = '#00a65a'
  //barChartData.datasets[1].strokeColor = '#00a65a'
  //barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  var myChart = barChart.Bar(barChartData, barChartOptions)
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script>
<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'home.php?year='+$(this).val();
  });
});
</script>
</body>
</html>
