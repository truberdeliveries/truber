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

    $stmt = $conn->prepare("SELECT COUNT(*) AS num FROM booking where booking_status=1 AND driver_name=:email");
    $stmt->execute(['email'=>$admin['email']]);
    $rows = $stmt->fetch();


    if($rows['num']>0){
        header('location: accepted_ride.php');
    }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include './includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Available Requests
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Available Requests</li>
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

              <table id="example1" class="table table-bordered">
                  <thead>
                  <th>Payment Type</th>
                  <th>Customer Name</th>
                  <th>Pick-Up Address</th>
                  <th>Destination</th>
                  <th>Action</th>
                  </thead>
                  <tbody id="rides-list" class="rides-list">
                  <?php

                  try{

                      $stmt = $conn->prepare("SELECT * FROM booking where booking_status=0 ");
                      $stmt->execute();

                      foreach($stmt as $row){

                          echo "
                          <tr>
                            <td>".$row['payment_type']."</td>
                            <td>".$row['customer_name']."</td>
                            <td>".$row['start_address']."</td>
                            <td>".$row['end_address']."</td>
                            <td><button id=".$row['book_id']." class='btn btn-warning view-ride'><i class='fa fa-eye'></i> View</button></td>
                          </tr>
                        ";
                      }
                  }
                  catch(PDOException $e){
                      echo $e->getMessage();
                  }

                  ?>
                 </tbody>
              </table>
  
      </div>

      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<?php include 'rides/rides_modal.php'; ?>
<script>
    $(function(){

        $(document).on('click', '.view-ride', function(e){

            e.preventDefault();
            $('#view-ride').modal('show');
            var id = this.id;
            getRow(id);
        });

    });

    function getRow(id){

        $.ajax({
            type: 'POST',
            url: 'rides_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('#book_id').val(response.book_id);
                $('.fullname').html('Pick-Up Address: '+response.start_address+'<br/>Destination Address: '+response.end_address);
            }
        });
    }
</script>
<!-- Chart Data -->

<!-- End Chart Data -->

<?php $pdo->close(); ?>

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

var myVar = setInterval(checkStatus, 5000);

function checkStatus(){
    $.ajax({
        type: 'POST',
        url: 'get_rides.php',
        data: {},
        dataType: 'json',
        success: function(response){
          //  console.log(response.num +'--'+$('#example1_info').text()[18])
            if(response.num !== $('#example1_info').text()[18]){
               // $('.rides-list').load('.rides-list');
               window.location.reload();
            }

        }
    });
}
</script>
</body>
</html>
