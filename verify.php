<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	if(isset($_POST['login'])){
		
		$email = $_POST['email'];
        $mobile = $_POST['email'];
		$password = $_POST['password'];

		try{

			
			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM customer WHERE email=:email OR mobile=:mobile");
			$stmt->execute(['email'=>$email,'mobile'=>$mobile]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
					if($password == $row['password'])
					{
							$_SESSION['user'] = $row['id'];
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
			}
			else
			{

				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows1 FROM administrator WHERE email = :email OR mobile=:mobile");
				$stmt->execute(['email'=>$email,'mobile'=>$mobile]);
				$row = $stmt->fetch();

				if($row['numrows1'] > 0){
					if($password == $row['password']){
							$_SESSION['admin'] = $row['id'];
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
				}
				else
				{
					$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows2 FROM driver WHERE email = :email OR mobile=:mobile");
					$stmt->execute(['email'=>$email,'mobile'=>$mobile]);
					$row = $stmt->fetch();

					if($row['numrows2'] > 0){
						if($password == $row['password']){
								$_SESSION['driver'] = $row['id'];
						}
						else{
							$_SESSION['error'] = 'Incorrect Password';
						}
					}
					else
					{
						$_SESSION['error'] = 'Email not found';
					}

				}

			}
			

			
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}

if(isset($_POST['remember'])){

    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT *,COUNT(*) AS numrows FROM driver,customer,administrator WHERE driver.email=:email OR customer.email=:email OR administrator.email=:email ");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();
    if($row['numrows'] > 0){

        $to_email = $email;
        $subject = 'Password Recovery';
        $body = '
                <p>Hi '.$row['firstname'].' '.$row['lastname'].'</p>
                <br/>
                <p>Your Passowrd Is: '.$row['password'].'</p>
                <br/>
                <p>From <a href="http://127.0.0.1/truber/" style="color: #fed136;font-family: Kaushan Script,Helvetica Neue,Helvetica,Arial,cursive;">Truber</a> 
                Family</p> 
                ';
        $header = 'From: truber@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';

        if(mail($to_email,$subject,$body,$header)){
            $_SESSION['success'] = 'Password Has Been Sent To The Email: '.$email;
        }else{
            $_SESSION['error'] = 'Failed to send email...';
        }

    }else{
        $_SESSION['error'] = 'Email Does Not Exist';
    }

    header('location: recover_password.php');
    exit(0);
}

	$pdo->close();

	header('location: login.php');

?>