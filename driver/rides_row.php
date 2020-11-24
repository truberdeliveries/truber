<?php
include './includes/session.php';
$conn = $pdo->open();
if(isset($_POST['id'])){
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM booking WHERE book_id=:id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    echo json_encode($row);
}

if(isset($_POST['totals'])){
    $id = $_POST['totals'];

    $stmt = $conn->prepare("SELECT * FROM booking,type WHERE booking.book_id=:id AND booking.booking_status=3 AND type.image=booking.vehicle_type");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    echo json_encode($row);
}

if(isset($_POST['invoice'])){

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $invoice_id = 'Trub#'.substr(str_shuffle($permitted_chars), 0, 6);
    $customer_id = $_POST['customer_id'];
    $driver_id = $_POST['driver_id'];
    $amount = $_POST['amount'];
    $distance = $_POST['distance'];
    $vehicle_type = $_POST['vehicle_type'];
    $date_created = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO invoice VALUES (:invoice_id,:date_created,:customer_id,:driver_id,:amount,:distance_km,:vehicle_type)");
    $stmt->execute(['invoice_id'=>$invoice_id,'customer_id'=>$customer_id,'driver_id'=>$driver_id,'amount'=>$amount,'distance_km'=>$distance,'date_created'=>$date_created,'vehicle_type'=>$vehicle_type]);

    header('location: '.$_SERVER['HTTP_REFERER']);
}

if(isset($_POST['map_id'])){

    $coord = $_POST['values'];
    $stmt = $conn->prepare("UPDATE booking SET driver_coord=:driver_coord WHERE booking_status=1 AND driver_id=:id");
    $stmt->execute(['driver_coord'=>$coord,'id'=>$admin['id']]);
    $row = $stmt->fetch();

    echo json_encode($row);
}

if(isset($_POST['book_id'])){
    $id = $_SESSION['driver'];
    $book_id = $_POST['book_id'];
    //$start_time = date('H:i:s');

    $stmt = $conn->prepare("UPDATE booking SET driver_id=:driver_id, booking_status=1 WHERE book_id=:book_id");
    $stmt->execute(['book_id'=>$book_id,'driver_id'=>$id]);

    header('location: accepted_ride.php');
}
if(isset($_POST['pick_up'])){

    $book_id = $_POST['booking_id'];
    $start_time = date('H:i:s');


    $stmt = $conn->prepare("UPDATE booking SET start_time=:start_time,booking_status=2 WHERE book_id=:book_id");
    $stmt->execute(['start_time'=>$start_time,'book_id'=>$book_id]);

    $stmts = $conn->prepare("SELECT start_time FROM booking WHERE book_id=:book_id");
    $stmts->execute(['book_id'=>$book_id]);
    $row = $stmts->fetch();
    echo json_encode($row);

}
if(isset($_POST['finish'])){

    $book_id = $_POST['booking_id'];
    $end_time = date('H:i:s');


    $stmt = $conn->prepare("UPDATE booking SET end_time=:end_time,booking_status=3  WHERE book_id=:book_id");
    $stmt->execute(['end_time'=>$end_time,'book_id'=>$book_id]);

    $stmts = $conn->prepare("SELECT start_time,end_time FROM booking WHERE book_id=:book_id");
    $stmts->execute(['book_id'=>$book_id]);
    $row = $stmts->fetch();


    $date_a = new DateTime('2010-10-20'.$row['start_time']);
    $date_b = new DateTime('2010-10-20'.$row['end_time']);

    $interval = date_diff($date_a,$date_b);

    $row = array('total_time'=> $interval->format('%h:%i:%s'));
    echo json_encode($row);
}

if(isset($_POST['trip_id'])){

    $book_id = $_POST['trip_id'];

    $stmt = $conn->prepare("UPDATE booking SET booking_status=4 WHERE book_id=:book_id");
    $stmt->execute(['book_id'=>$book_id]);

    header('location: available_rides.php');
}

$pdo->close();
?>