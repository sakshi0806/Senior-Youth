<?php
include './includes/preferences.php';
include HEADER;


$errors = array();
$msg = array();
require_once PSQL;


//USERNAME
if(filter_input(INPUT_POST,'cusername')){
    $n = FALSE;
    $check_n = 0;
    if(between($_POST['uname'],5,50)){
        $un = pg_escape_string($_POST['uname']);
        $query1 ="SELECT * FROM users WHERE username = '".$un."'";
        $data = pg_query($dbcl,$query1); 
        // $row = pg_fetch_row($data);
        // $id = $row[2];
        // echo $id;
        $check_n = pg_num_rows($data);
        if($check_n > 0){ 
            $errors['uname'] = 'Sorry, this username is already registered <br>.';
        }
        else{
            $query = " UPDATE users SET username='".$un."' WHERE user_id=".$_SESSION['user_id']."";
            $stmt = pg_query($dbcl, $query);
            $_SESSION['username'] = $un;
            $msg['uname'] = " Username is Updated Successfully.";   
            //header('Location:http://localhost/SeniorYouth/myaccount.php');
            //if(pg_affected_rows($stmt) == 1){
            //}
            //else{
            //    $errors['uname'] = '<p>System error occured, your username could not be updated.';
            //}
        }
    }
    else{
        $errors['uname'] = 'Username should be within 5-50 characters<br>';
    }
}

//CHANGE FIRST NAME
if(filter_input(INPUT_POST,'cfname')){
    $fn = FALSE;
    echo $_POST['fname'];
    if(between($_POST['fname'],2,20)){
		$fn = pg_escape_string($_POST['fname']);
	}
	else{
		$errors['fname'] = 'First Name should be within 2-20 characters';
	}
    if($fn){
        if($_SESSION['role_id'] == 1)
            $query = " UPDATE senior_data SET first_name='".$fn."' WHERE user_id=".$_SESSION['user_id']."";
        else
            $query = " UPDATE youth_data SET y_first_name='".$fn."' WHERE user_id=".$_SESSION['user_id']."";
        $stmt = pg_query($dbcl, $query);
        $_SESSION['first_name'] = $fn;
        $_SESSION['full_name'] = $fn.' '.$_SESSION['last_name'];
        //header('Location:http://localhost/SeniorYouth/myaccount.php');
        // if(pg_affected_rows($stmt) == 1){
        $msg['fname'] = " First name is Updated Successfully.";
            
        // }
        // else{
        //     $errors['fname'] = '<p>System error occured, your First name could not be updated.';
        // }
    }
}

//CHANGE LAST NAME
if(filter_input(INPUT_POST,'clname')){
    $ln = FALSE;
    if(between($_POST['lname'],2,40)){
		$ln = pg_escape_string($_POST['lname']);
	}
	else{
		$errors['lname'] = 'Last Name should be within 2-40 characters';
	}
    if($ln){
        if($_SESSION['role_id'] == 1)
            $query = " UPDATE senior_data SET last_name='".$ln."' WHERE user_id=".$_SESSION['user_id']."";
        else
            $query = " UPDATE youth_data SET y_last_name='".$ln."' WHERE user_id=".$_SESSION['user_id']."";
        $stmt = pg_query($dbcl, $query);
        $_SESSION['last_name'] = $ln;
        $_SESSION['full_name'] = $_SESSION['first_name'].' '.$ln;
        //header('Location:http://localhost/SeniorYouth/myaccount.php');
        // if(pg_affected_rows($stmt) == 1){
            $msg['lname'] = " Last name is Updated Successfully.";
            
        // }
        // else{
        //     $errors['lname'] = '<p>System error occured, your Last name could not be updated.';
        // }
    }
}

//CHANGE Contact
if(filter_input(INPUT_POST,'ccontact')){
    $c = FALSE;
    if(between($_POST['contact'],10,10)){
		$c = pg_escape_string($_POST['contact']);
	}
	else{
		$errors['contact'] = 'Contact should be of 10 characters';
	}
    if($c){
        if($_SESSION['role_id'] == 1)
            $query = " UPDATE senior_data SET contact_no='".$c."' WHERE user_id=".$_SESSION['user_id']."";
        else
            $query = " UPDATE youth_data SET y_contact_no='".$c."' WHERE user_id=".$_SESSION['user_id']."";
        $stmt = pg_query($dbcl, $query);
        $_SESSION['contact'] = $c;
        //header('Location:http://localhost/SeniorYouth/myaccount.php');
        // if(pg_affected_rows($stmt) == 1){
            $msg['contact'] = " Contact is Updated Successfully.";
            
        // }
        // else{
        //     $errors['lname'] = '<p>System error occured, your Last name could not be updated.';
        // }
    }
}

//CHANGE EMAIL
if(filter_input(INPUT_POST,'cemail')){
    $e = FALSE;
    $check_e = 0;
    $e = pg_escape_string($_POST['email']);
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strlen($_POST['email']) <= 80){
        $query1 ="SELECT * FROM users WHERE email_id = '".$e."'";
        $data = pg_query($dbcl,$query1); 
        // $row = pg_fetch_row($data);
        // $id = $row[2];
        // echo $id;
        $check_e = pg_num_rows($data);
        if($check_e > 0){ 
            $errors['email'] = 'Sorry, this email is already registered <br>.'.$e.'';
        }
        else{
            $query = " UPDATE users SET email_id='".$e."' WHERE user_id=".$_SESSION['user_id']."";
            $stmt = pg_query($dbcl, $query);
            $_SESSION['email_id'] = $e;
            //header('Location:http://localhost/SeniorYouth/myaccount.php');
            // if(pg_affected_rows($stmt) == 1){
                $msg['email'] = " Email ID is Updated Successfully.";   
            // }
            // else{
            //     $errors['email'] = '<p>System error occured, your Last name could not be updated.';
            // }
        }
    }
    else{
        $errors['email'] = 'Please provide a valid email address <br>'.$e.'';
    }
}

//CHANGE PASSWORD
if(filter_input(INPUT_POST,'cpassword')){

    echo $_POST['npassword'];
    echo $_POST['currpassword'];
    echo $_SESSION['pass'];

    if(between($_POST['npassword'],8,20)){
		$np = pg_escape_string($_POST['npassword']);
        $op1 = pg_escape_string($_POST['currpassword']);
        $op2 = $_SESSION['pass'];

        $verify = password_verify($op1, $op2);

        if($verify){
            $hash = password_hash($np, PASSWORD_BCRYPT);
            $query = " UPDATE users SET password='".$hash."' WHERE user_id=".$_SESSION['user_id']."";
            $stmt = pg_query($dbcl, $query);
            $_SESSION['pass'] = $hash;
            $msg['npassword'] = 'Password is Updated Successfully.'; 
            //header('Location:http://localhost/SeniorYouth/myaccount.php');
            //echo '<script>console.log("'.$stmt.'"); </script>';
            // if(pg_affected_rows($stmt) == 1){
              
            //     echo "doneeeeeeeeeeeee";
            // }
            // else{
            //     $errors['npassword'] = 'System error occured, your Password could not be updated.';
            // }
        }
        else{
            $errors['currpassword'] = 'Current Passwrod does not match the entered password.';
        }
        
	}
	else{
		$errors['npassword'] = 'Password should be within 2-20 characters';
	}
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Senior Youth</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/simplegrid.css">
        <link rel="stylesheet" href="css/icomoon.css">
        <link rel="stylesheet" href="css/lightcase.css">
        <link rel="stylesheet" href="style.css">

        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <style>

        span {
            font-size: 12px;
        }
        
        input[type="checkbox"] {
            accent-color: #1abc9c;
            cursor: pointer;
            margin: 0px !important;
        }

        
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
            font-size: 25px;
            text-align: center;
            /* background-color: white; */
        }

        table{
            border: 1px solid black;
            width: 90%
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        a{
            color:red;
        }

        a:hover{
            color:black;
            cursor: pointer;
        }

        button {
            border-radius: 20px;
            border: 1px solid #31d3b3;
            /* background: linear-gradient(to right, #12e2b8, #1abc9c); */
            background: linear-gradient(to right, #31d3b3, #1abc9c);
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            }

            th{
                /* background-color :#57c9b2; */
                background: linear-gradient(to right, #31d3b3, #1abc9c); */
                color:white;
                
            }
            button:active {
                transform: scale(0.95);
            }

            button:focus {
                outline: none;
            }

            button:hover {
                cursor: pointer;
            }

            button.ghost {
                background-color: transparent;
                border-color: #FFFFFF;
            }

            input.small{
                height:22px !important;
            }

            input#eye {
                width: 10% !important;
                vertical-align: text-bottom !important;
            }

            input#input1{
                margin-bottom: 5px !important;
            }

            input[type="text"] , input[type="password"]{
                margin-top: 10px;
            }

    </style>
    
    </head>

    <!-- HOME Section -->
    <div class="parallax-section parallax1">
                <div class="grid grid-pad">
                    <div class="col-1-1">
                         <div class="content content-header" >
                            <br>
                            <h2>Welcome 
                                <?php
                                if(isset($_SESSION['user_id'])){
                                    echo $_SESSION['full_name'];
                                }
                                else if(isset($_SESSION['y_user_id'])){
                                    echo $_SESSION['y_full_name'];
                                }
                                else{
                                    echo "Guest";
                                }
                            
                            ?>  
                            </h2>
                            <h2>YOUR ACCOUNT</h2>
                        </div>
                    </div>
                </div>
            <!-- this one -->
                </div>
            <!-- End Parallax Section -->

            <?php 
                require_once PSQL;
                if(isset($_SESSION['user_id'])){ 
                    $query = "SELECT * FROM users WHERE user_id=".$_SESSION['user_id'].""; 
                }
                else if(isset($_SESSION['y_user_id'])){
                    $query = "SELECT * FROM youth WHERE y_user_id=".$_SESSION['y_user_id']."";
                }
                $data = pg_query($dbcl, $query);
                //$data = pg_fetch_row($rs);
                $row = pg_fetch_row($data);
                $n = 0;
                ?>
                <br><br>
                <table class='center'>
                <tr>
                    <th>User/Admin</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Password <div>
                    <span id=mid>Show Password  </span><input type="checkbox" id="eye" class="small" onchange="toogleInput(this)"></div>
                    </th>
                </tr>

                <tr><td rowspan=2>
                <?php
                if($row[0] == 1){
                    echo 'Admin';
                }
                else{
                    echo 'User';
                }
                ?>
                </td>
                <?php
                if(isset($_SESSION['user_id'])){ ?>
                    <td> <?php echo $_SESSION['username'] ?> </td>
                    <td> <?php echo $_SESSION['first_name'] ?> </td>
                    <td> <?php echo $_SESSION['last_name'] ?> </td>
                    <td> <?php echo $_SESSION['contact'] ?> </td>
                    <td> <?php echo $_SESSION['email_id'] ?> </td>
                <?php }
                else if(isset($_SESSION['user_id'])){ ?>
                    <td> <?php echo $_SESSION['username'] ?> </td>
                <td> <?php echo $_SESSION['first_name'] ?> </td>
                <td> <?php echo $_SESSION['last_name'] ?> </td>
                <td> <?php echo $_SESSION['contact'] ?> </td>
                <td> <?php echo $_SESSION['email_id'] ?> </td>
                <?php }
                
                ?>
                <!-- PASSWORD -->
                <td rowspan=2> <form action="myaccount.php" method="post">
                    <input type="password" name="currpassword" placeholder="Enter Current password" class="password" id="input1"> 
                    <span>
                        <?php 
                        echo isset($errors['currpassword'])?$errors['currpassword']:'';
                        ?>
                    </span>
                    <input type="password" name="npassword" placeholder="Enter New Password" class="password">
                    <span>
                        <?php 
                        echo isset($errors['npassword'])?$errors['npassword']:'';
                        ?>
                    </span>
                    <button type="submit" name="cpassword" value="cpassword">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['npassword'])?$msg['npassword']:''; 
                        ?>
                    </span>
                    </form></td>

                </tr>    
                <tr>

                <!-- USERNAME -->
                <td>
                <form action="myaccount.php" method="post">
                    <input type="text" placeholder="Username" name="uname" value=""/>
                    <span>
                        <?php 
                        echo isset($errors['uname'])?$errors['uname']:''; 
                        ?>
                    </span>
                    <button type="submit" name="cusername" value="cusername">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['uname'])?$msg['uname']:''; 
                        ?>
                    </span>
                </form>

                </td>
                <!-- FIRST NAME -->
                <td>
                    <form action="myaccount.php" method="post">
                    <input type="text" placeholder="First Name" name="fname" value=""/>
                    <span>
                        <?php 
                        echo isset($errors['fname'])?$errors['fname']:''; 
                        ?>
                    </span>
                    <button type="submit" name="cfname" value="cfname">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['fname'])?$msg['fname']:''; 
                        ?>
                    </span>
                </form></td>

                <!-- LAST NAME -->
                <td>
                <form action="myaccount.php" method="post">
                    <input type="text" placeholder="Last Name" name="lname" value=""/>
                    <span>
                        <?php 
                        echo isset($errors['lname'])?$errors['lname']:'';
                        ?>
                    </span>
                    <button type="submit" name="clname" value="clname">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['lname'])?$msg['lname']:''; 
                        ?>
                    </span>
                </form></td>
                </td>

                <!-- CONTACT -->
                <td>
                <form action="myaccount.php" method="post">
                    <input type="text" placeholder="Contact" name="contact" value=""/>
                    <span>
                        <?php 
                        echo isset($errors['contact'])?$errors['contact']:'';
                        ?>
                    </span>
                    <button type="submit" name="ccontact" value="ccontact">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['contact'])?$msg['contact']:''; 
                        ?>
                    </span>
                </form></td>
                </td>

                <!-- EMAIL -->
                <td>
                <form action="myaccount.php" method="post">
                    <input type="text" placeholder="Email" name="email" value=""/>
                    <span>
                        <?php 
                        echo isset($errors['email'])?$errors['email']:'';
                        ?>
                    </span>
                    <button type="submit" name="cemail" value="cemail">Change</button>
                    <span><br>
                        <?php 
                            echo isset($msg['email'])?$msg['email']:''; 
                        ?>
                    </span>
                </form></td>
            
                </tr> 

                </table><br><br><br>

                <br><br><br>
                <br><br><br>
                <br><br><br>
                <br><br><br>
                <br><br><br>
                <?php
                    pg_close($dbcl); 
                ?>

                <!-- this one -->
                <!-- </div> -->

<script>
// function myFunction() {
//   var x = document.getElementById("myInput");
//   if (x.type === "password") {
//     x.type = "text";
//   } else {
//     x.type = "password";
//   }
// }

// function myFunction1() {
//   var x = document.getElementById("myInput1");
//   if (x.type === "password") {
//     x.type = "text";
//   } else {
//     x.type = "password";
//   }
// }

function toogleInput(e) {
  var list = document.getElementsByClassName('password');
  for (let item of list) {
    item.type = e.checked ? 'text' : 'password';
  }
}
</script>


</html>
