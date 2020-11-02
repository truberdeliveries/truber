<?php
include './includes/session.php';


    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT COUNT(book_id) AS num FROM booking where booking_status=0 ");
    $stmt->execute();
    $row = $stmt->fetch();

    $pdo->close();

    echo json_encode($row);

?>