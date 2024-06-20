<?php 
session_start();
$loggedIn = $admin = FALSE;
if(isset($_SESSION['user_id'])){
	$loggedIn = TRUE;
	if(isset($_SESSION['user_level'])){
		if($_SESSION['user_level'] == 1){
			$admin = TRUE;
		}
	}
}

include '../includes/preferences.php';

if(isset($_SESSION['user_id'])){
	header('Location: '.BASE_URL);
	exit();
}

//REGISTER BUTTON
if(filter_input(INPUT_POST,'register')){
	require MYSQL;
	$fn = $ln = $un = $p = $e = $c = $rid = FALSE;
	//echo $rid;

	// ROLE ID
	$errors = array();
	if(isset($_POST['roleid'])){
		$rid = $_POST["roleid"];
	}
	else{
		$errors['roleid'] = 'Please select a role.';
	}

	// EMAIL
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strlen($_POST['email']) <= 80){
		$e = pg_escape_string($_POST['email']);
	}
	else{
		$errors['email'] = 'Please provide a valid email address';
	}

	// FIRST NAME
	if(between($_POST['first_name'],2,20)){
		$fn = pg_escape_string($_POST['first_name']);
	}
	else{
		$errors['first_name'] = 'First Name should be within 2-20 characters';
	}

	// LAST NAME
	if(between($_POST['last_name'],2,40)){
		$ln = pg_escape_string($_POST['last_name']);
	}
	else{
		$errors['last_name'] = 'Last Name should be within 2-40 characters';
	}

	// Contact
	if(between($_POST['contact'],10,10)){
		$c = pg_escape_string($_POST['contact']);
	}
	else{
		$errors['contact'] = 'Contact No should be of 10 Characters';
	}

	// USERNAME
	if(between($_POST['username'],5,50)){
		$un = pg_escape_string($_POST['username']);
	}
	else{
		$errors['username'] = 'Username should be within 5-50 characters';
	}

	// PASSWORD
	if(between($_POST['password'],8,20)){
		if($_POST['password'] == $_POST['cpassword']){
			$p = pg_escape_string($_POST['password']);
		}else{
			$errors['cpassword'] = 'Password entered does not match.';
		}
	}
	else{
		$errors['password'] = 'Password should be within 8-20 characters';
	}

	if($fn && $ln && $un && $p && $e && $c && $rid){
		$taken = FALSE;

    	$query1 ="SELECT * FROM users WHERE email_id = '".$e."'";
    	$data = pg_query($dbcl,$query1); 
    	$check_e = pg_num_rows($data);
    	if($check_e > 0){ 
			//echo "Email already Registered";
			$taken = TRUE;
			$errors['email'] = 'Sorry, this email is already registered.';
		}

		$query2 ="SELECT * FROM users WHERE username = '".$un."'";
    	$data = pg_query($dbcl,$query2); 
    	$check_un = pg_num_rows($data);
    	if($check_un > 0){ 
			//echo "Email already Registered";
			$taken = TRUE;
			$errors['username'] = 'Sorry, this username is already taken.';
		}

		if(!$taken){
			//$query = "INSERT INTO users"
			//		. "(username, first_name, last_name, email_id, pin) VALUES (:username, :first_name, :last_name, :email_id, :password)";
			$hash = password_hash($p, PASSWORD_BCRYPT);
			
            $query = "INSERT INTO users(username, email_id, password, role_id) VALUES ('$un', '$e', '$hash' ,'$rid')";
            $stmt = pg_query($dbcl, $query);

			$q = "select * from users where username='$un' limit 1";
			$q1 = pg_query($dbcl, $q);
			$row = pg_fetch_row($q1);
			$fkid = $row[0];

			if($rid == 1){
				$query1 = "INSERT INTO senior_data(user_id, first_name, last_name, contact_no) VALUES ('$fkid', '$fn', '$ln', '$c')";
				$stmt1 = pg_query($dbcl, $query1);
			}else
			if($rid == 2){
				$query1 = "INSERT INTO youth_data(user_id, y_first_name, y_last_name, y_contact_no) VALUES ('$fkid', '$fn', '$ln', '$c')";
				$stmt1 = pg_query($dbcl, $query1);
			}


			// $query1 = "INSERT INTO senior_data(user_id, first_name, last_name, contact_no) VALUES ('$fkid', '$fn', '$ln', '$c')";
			// $stmt1 = pg_query($dbcl, $query1);

			if(pg_affected_rows($stmt) == 1 && pg_affected_rows($stmt1) == 1){
				//echo "Thank you for registering.";
				$_SESSION['msg'] = '<p class="msg">Your account is registered successfully.<br>You can now proceed by loging in your account.';
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
					session_destroy();
					setcookie(session_name(),'',time()-3600);
				}
				
				// 	$stmt->close();
				// 	unset($stmt);
				pg_close($dbcl);
				// 	unset($dbcl);
				//header('Location: http://localhost/SeniorYouth/login/logsignup.php');
				//echo '<script>alert("Your account is registerd successfully.You can now proceed by loging in")</script>';
				
			}
			else{
				$general_msg = '<p>System error occured, ypur account could not be registered. ' .$stmt->error;
			}
		}
		// $stmt->close();
		// 		unset($stmt);
		// 		$dbcl->close();
		// 		unset($dbcl);
	}

}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
	<title>Register</title>

	<style>
		input[type="checkbox"] {
            accent-color: #1abc9c;
            cursor: pointer;
            margin: 0px !important;
        }

		input#eye {
                width: 10% !important;
                vertical-align: middle !important;
            }

			span#mid{
            font-size: 14px;
        }

		input.small{
                height:22px !important;
            }

			a:hover{
				color :#1abc9c;
			}

			a{
				margin:2px !important;
			}

			button:hover{
                background-color : white;
                color: #1abc9c;
            }

			input[type="radio"]{
				margin:0;
				padding:0;
				width:20px;;
			}

			.radios{
				display: inline;
			}

			.container {
				height: 669px !important;
			}

	</style>

</head>
    
<body>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
			session_destroy();
			setcookie(session_name(),'',time()-3600);
		}
		echo isset($general_msg)?$general_msg:''; 
		?>

		<form action="register.php" method="POST">
			<h1>Create Account</h1>
			<br>
			<div class="radios">
			<input type="radio" id="senior" name="roleid" value="1">
			  <label for="senior">Senior</label>
			  <input type="radio" id="youth" name="roleid" value="2">
			  <label for="youth">Youth</label>
			</div>
			<span>
				<?php echo isset($errors['roleid'])?$errors['roleid']:''; ?>
			</span>
			<!-- <a href="register_youth.php"><span>As Seniors</span></a> -->
			<!-- FIRST NAME -->
			<input type="text" placeholder="First Name" name="first_name" value="<?php  
				echo isset($_POST['first_name'])?$_POST['first_name']:'';
			?>"/>
			<span>
				<?php 
				echo isset($errors['first_name'])?$errors['first_name']:''; 
				?>
			</span>

			<!-- LAST NAME -->
			<input type="text" placeholder="Last Name" name="last_name" value="<?php  
				echo isset($_POST['last_name'])?$_POST['last_name']:'';
			?>"/>
			<span>
				<?php echo isset($errors['last_name'])?$errors['last_name']:''; ?>
			</span>
			
			<!-- EMAIL -->
			<input type="email" placeholder="Email" name="email" value="<?php  
				echo isset($_POST['email'])?$_POST['email']:'';
			?>"/>
			<span>
				<?php echo isset($errors['email'])?$errors['email']:''; ?>
			</span>

			<!-- Contact -->
			<input type="text" placeholder="Contact No" name="contact" value="<?php  
				echo isset($_POST['contact'])?$_POST['contact']:'';
			?>"/>
			<span>
				<?php echo isset($errors['contact'])?$errors['contact']:''; ?>
			</span>
			
			<!-- USERNAME -->
			<input type="text" placeholder="Username" name="username" value="<?php  
				echo isset($_POST['username'])?$_POST['username']:'';
			?>"/>
			<span>
				<?php echo isset($errors['username'])?$errors['username']:''; ?>
			</span>
			
			<!-- PASSWORD -->
			<input type="password" class="password" placeholder="Password" name="password" value="<?php  
				echo isset($_POST['password'])?$_POST['password']:'';
			?>"/>
			<span>
				<?php echo isset($errors['password'])?$errors['password']:''; ?>
			</span>

			<!-- CONFIRM PASSWORD -->
			<input type="password" class="password" placeholder="Confirm Password" name="cpassword" value="<?php  
				echo isset($_POST['cpassword'])?$_POST['cpassword']:'';
			?>"/>
			<span>
				<?php echo isset($errors['cpassword'])?$errors['cpassword']:''; ?>
			</span>

			<span id=mid>Show Password  <input type="checkbox" id="eye" class="small" onchange="toogleInput(this)">
			</span>
			<br>
			<button  name="register" value="register">Register</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
        <div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<a href="login.php"><button class="ghost">Sign In</button></a>
				<!-- <a href="login_youth.php"><button class="ghost">Sign In as Youth</button></a> -->
			</div>
		</div>
	</div>
</div>
    </body>

	<script>
		function toogleInput(e) {
			var list = document.getElementsByClassName('password');
			for (let item of list) {
				item.type = e.checked ? 'text' : 'password';
			}
		}

	</script>
</html>
