<?php

include 'includes/session.php';

if(isset($_POST['cord'])){

    $cust_id = $admin['id'];
    $payment = $_POST['payment'];
    $type= $_POST['type'];
    $start = $_POST['start'];
    $coordinates = $_POST['cord'];
    $destination = $_POST['destination'];

    $conn = $pdo->open();

    $now = date('Y-m-d');

    try{

        $stmt = $conn->prepare("INSERT INTO booking (start_address,end_address,coordinates,date,cust_id,payment_type,vehicle_type,booking_status) 
        VALUES (:start_address,:end_address,:coordinates, :date, :cust_id, :payment_type, :vehicle_type, :booking_status)");
        $stmt->execute(['start_address'=>$start, 'end_address'=>$destination,'coordinates'=>$coordinates, 'date'=>$now,
                        'cust_id'=>$cust_id, 'payment_type'=>$payment, 'vehicle_type'=>$type,'booking_status'=>0]);

        $userid = $conn->lastInsertId();

        $_SESSION['requested'] = 'Successfully Made A Request, Please wait while we look for driver...';
        header('location: request.php');


    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        echo $e->getMessage();
       // header('location: request.php');
    }

    $pdo->close();


}
else{
    $_SESSION['error'] = 'Make a request first';
    header('location: request.php');
}



?>