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
if(isset($_POST['book_id'])){
    $email = $admin['email'];
    $book_id = $_POST['book_id'];
    //$start_time = date('H:i:s');

    $stmt = $conn->prepare("UPDATE booking SET driver_name=:driver_name, booking_status=1 WHERE book_id=:book_id");
    $stmt->execute(['book_id'=>$book_id,'driver_name'=>$email]);

    header('location: accepted_ride.php');
}
if(isset($_POST['pick_up'])){

    $book_id = $_POST['booking_id'];
    $start_time = date('H:i:s');


    $stmt = $conn->prepare("UPDATE booking SET start_time=:start_time WHERE book_id=:book_id");
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