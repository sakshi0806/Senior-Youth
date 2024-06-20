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

//LOGIN BUTTON
if(filter_input(INPUT_POST,'login')){
	require MYSQL;
	$errors = array();
    $id = pg_escape_string($_POST['id']);
    $password = pg_escape_string($_POST['password']);
    $valid = TRUE;
    $query = "SELECT * FROM users WHERE ";
    if(filter_var($id, FILTER_VALIDATE_EMAIL) && strlen($id) <= 80){
        $query .= "email_id = '$id' limit 1";
    }
    else if(between($id, 5, 50)){
        $query .= "username = '$id' limit 1";
    }
    else{
        $errors['id'] = 'Please enter a valid username/e-mail address.';
        $valid = FALSE;
    }

    if(!between($password, 8, 20)){
        $errors['password'] = 'Please enter a valid password';
        $valid = FALSE;
    }

    if($valid){
        $data = pg_query($dbcl,$query); 
    	$check = pg_num_rows($data);
    	if($check > 0){ 
            $row = pg_fetch_row($data);
			
			$verify = password_verify($password, $row[3]);

            if ($verify) {
				if($row[5] == 1){
					$query1 = "SELECT * FROM senior_data WHERE user_id='$row[0]'";
					$data1 = pg_query($dbcl, $query1);
					$row1 = pg_fetch_row($data1);
				}else 
				if($row[5] == 2){
					$query1 = "SELECT * FROM youth_data WHERE user_id='$row[0]'";
					$data1 = pg_query($dbcl, $query1);
					$row1 = pg_fetch_row($data1);
				}

				// $query1 = "SELECT * FROM senior_data WHERE user_id='$row[0]'";
				// $data1 = pg_query($dbcl, $query1);
				// $row1 = pg_fetch_row($data1);

                 $_SESSION = array(
                    'user_id' => $row[0],
                    'username' => $row[1],
					'senior_id' => $row1[1],
					'first_name' => $row1[2],
					'last_name' => $row1[3],
                    'full_name' => $row1[2].' '.$row1[3],
					'contact' => $row1[4],
                    'email_id' => $row[2],
					'pass' => $row[3],
                    'user_level' => $row[4],
					'role_id' => $row[5]
                    );
                    header('Location:http://localhost/SeniorYouth');
                    exit();
            }
            else{
                $msg = '<p class="msg">Incorrect Password<br>Please try again</p>';
            }	    
        }
        else{
            $msg = '<p class="msg">No such user is available</p>';
        }
        echo $msg;
    }
    
        pg_close($dbcl);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>LogIn</title>
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

	</div>
	<div class="form-container sign-in-container">
		<form action="login.php" method="POST">
			<h1>Login</h1>
			<!-- <a href="login_youth.php"><span>As Seniors</span></a> -->
			<br>
			<!-- EMAIL/USERNAME -->
			<input type="text" placeholder="Email/Username" name="id" value="<?php
				echo isset($id)?$id:''; ?>"/>
			<span>
				<?php 
				echo isset($errors['id'])?$errors['id']:''; ?>
			</span>

			<!-- PASSWORD -->
			<input type="password" placeholder="Password" name="password" class="password" value="<?php
				echo isset($password)?$password:''; ?>"/>
			<span>
				<?php 
				echo isset($errors['password'])?$errors['password']:''; ?>
			</span>
			<div>
                    <!-- <span id=mid>Show Password  </span>
					<input type="checkbox" id="eye" class="small" onclick="myFunction()"> -->
					<span id=mid>Show Password<input type="checkbox" id="eye" class="small" onchange="toogleInput(this)">
			</span>
			</div>


			<a href="#">Forgot your password?</a><br>
			<button type="submit" name="login" value="login">LogIn</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<a href="register.php"><button class="ghost">Signup now</button></a>
				<!-- <a href="register_youth.php"><button class="ghost">Signup now as Youth</button></a> -->
			</div>
		</div>
	</div>
</div>
    </body>



    <script src="javascript.js"></script>
	<script>

function toogleInput(e) {
			var list = document.getElementsByClassName('password');
			for (let item of list) {
				item.type = e.checked ? 'text' : 'password';
			}
		}


</script>
</html>
