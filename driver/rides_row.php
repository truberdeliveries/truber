<?php
include './includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $conn = $pdo->open();

    $stmt = $conn->prepare("SELECT * FROM booking WHERE book_id=:id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    $pdo->close();

    echo json_encode($row);
}
if(isset($_POST['book_id'])){
    $email = $admin['email'];
    $book_id = $_POST['book_id'];
    $start_time = date('H:i:s');

    $conn = $pdo->open();

    $stmt = $conn->prepare("UPDATE booking SET driver_name=:driver_name, booking_status=1, start_time=:start_time WHERE book_id=:book_id");
    $stmt->execute(['book_id'=>$book_id,'driver_name'=>$email,'start_time'=>$start_time]);

    $pdo->close();

    header('location: accepted_ride.php');
}
?>