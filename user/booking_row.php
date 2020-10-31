<?php 
	include 'includes/session.php';

        $email = $admin['email'];
		
		$conn = $pdo->open();

        $stmt = $conn->prepare("SELECT booking_status FROM booking WHERE customer_name =:email AND booking_status=1");
        $stmt->execute(['email'=>$email]);

		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);

?>