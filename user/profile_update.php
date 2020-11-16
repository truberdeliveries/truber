<?php
	include 'includes/session.php';

	if(isset($_GET['return'])){
		$return = $_GET['return'];
		
	}
	else{
		$return = 'home.php';
	}

	if(isset($_POST['save'])){

		$curr_password = $_POST['curr_password'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$mobile = $_POST['mobile'];

//
//        $photo = $_FILES['photo']['name'];
//        $target_dir = "assets/";
//        $target_file = $target_dir . basename($photo);
//
//        // Select file type
//        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//
//        // Check extension
//        $allowTypes = array('jpg','png','jpeg','gif');
//        if(!in_array($imageFileType, $allowTypes)){
//            $_SESSION['error'] = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
//            header('location:'.$return);
//        }


        if($curr_password == $admin['password']){
			
			if($password == $admin['password']){
				$password = $admin['password'];
			}
			else{
				$password = $password;
			}

			$conn = $pdo->open();

			try{
                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM customer WHERE email=:email AND id <>:id");
                $stmt->execute(['email'=>$email, 'id'=>$admin['id']]);
                $row = $stmt->fetch();
                if($row['numrows'] > 0){
                    $_SESSION['error'] = 'Email already exits';
                }
                else {
                    $stmt = $conn->prepare("UPDATE customer SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, mobile=:mobile WHERE id=:id");
                    $stmt->execute(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'mobile' => $mobile, 'id' => $admin['id']]);

                    // Upload file
                    //move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$photo);
                    $_SESSION['success'] = 'Account updated successfully';
                }
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}



			$pdo->close();
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up required details first';
	}

	header('location:'.$return);

?>