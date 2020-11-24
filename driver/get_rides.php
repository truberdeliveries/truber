<?php
include './includes/session.php';


    $conn = $pdo->open();
//    $stmt = $conn->prepare("SELECT COUNT(book_id) AS num FROM booking,type
//                                     WHERE booking.booking_status=0 AND booking.vehicle_type=type.name");
$stmt = $conn->prepare("SELECT COUNT(book_id) AS num FROM booking,vehicle where booking_status=0 
                                                       AND vehicle.type=booking.vehicle_type 
                                                       AND vehicle.driver_id=:id ");
    $stmt->execute(['id'=>$admin['id']]);
    $row = $stmt->fetch();

    $pdo->close();

    echo json_encode($row);

?>