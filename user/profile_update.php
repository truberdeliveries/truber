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

        $photo = $_FILES['photo']['name'];

        $target_dir = "C:/xampp/htdocs/Truber/assets/img/photos/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $_SESSION['error'] = "File is not an image.";
                $uploadOk = 0;
                header('location:'.$return);
            }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION['error'] = "Sorry, file already exists.";
            $uploadOk = 0;
            header('location:'.$return);
        }

// Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
            $uploadOk = 0;
            header('location:'.$return);
        }

// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            header('location:'.$return);
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['error'] = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                header('location:'.$return);
            }
        }


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
                    $stmt = $conn->prepare("UPDATE customer SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, mobile=:mobile,photo=:photo WHERE id=:id");
                    $stmt->execute(['email' => $email, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'mobile' => $mobile, 'id' => $admin['id'],'photo'=>$photo]);

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