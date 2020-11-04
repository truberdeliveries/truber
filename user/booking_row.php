<?php 
	include 'includes/session.php';
$conn = $pdo->open();
if(isset($_POST['id_check'])){
    $id = $admin['email'];

    $stmt = $conn->prepare("SELECT * FROM booking WHERE customer_name=:customer_name AND booking_status=1");
    $stmt->execute(['customer_name'=>$id]);
    $row = $stmt->fetch();

    echo json_encode($row);
}
if(isset($_POST['id'])){
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM booking WHERE book_id=:id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    echo json_encode($row);
}
if(isset($_POST['ride_check'])){
    $id = $_POST['booking_id'];

    $stmt = $conn->prepare("SELECT * FROM booking WHERE book_id=:id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    echo json_encode($row);
}

if(isset($_POST['type'])) {
    $email = $admin['email'];

    $stmt = $conn->prepare("SELECT booking_status FROM booking WHERE customer_name =:email AND booking_status=1");
    $stmt->execute(['email' => $email]);

    $row = $stmt->fetch();



    echo json_encode($row);
}
if(isset($_POST['banking-details'])){

    $id = $admin['id'];
    $date_created = date('Y-m-d');
    $bankname = $_POST['name'];
    $cardnumber= $_POST['card-number'];
    $branch = $_POST['branch'];

    $stmt = $conn->prepare("INSERT INTO card VALUES (:id, :bankname,:cardnumber,:branch,:date_created)");
    $stmt->execute(['id'=>$id,'bankname'=>$bankname,'cardnumber'=>$cardnumber,'branch'=>$branch,'date_created'=>$date_created]);

    header('location: request.php');
}
if(isset($_POST['check_card'])){

    $cardnumber = $_POST['check_card'];
    $bankname = $_POST['bank'];

    $stmts = $conn->prepare("SELECT * FROM card WHERE cardnumber=:cardnumber AND bankname=:bankname AND id=:id");
    $stmts->execute(['id'=>$admin['id'],'bankname'=>$bankname,'cardnumber'=>$cardnumber]);
    $row = $stmts->fetch();

    echo json_encode($row);
}

if(isset($_POST['trip_id'])){

    $book_id = $_POST['trip_id'];

    $stmt = $conn->prepare("UPDATE booking SET booking_status=4 WHERE book_id=:book_id");
    $stmt->execute(['book_id'=>$book_id]);

    header('location: home.php');
}

if(isset($_POST['finish_id'])){

    $book_id = $_POST['finish_id'];
    $end_time = date('H:i:s');

    $stmts = $conn->prepare("SELECT * FROM booking WHERE book_id=:book_id");
    $stmts->execute(['book_id'=>$book_id]);
    $row = $stmts->fetch();


    $date_a = new DateTime('2010-10-20'.$row['start_time']);
    $date_b = new DateTime('2010-10-20'.$row['end_time']);

    $interval = date_diff($date_a,$date_b);

    $row = array('total_time'=> $interval->format('%h:%i:%s'));
    echo json_encode($row);
}

$pdo->close();
?>