<?php 
session_start();
$loggedIn = $admin = FALSE;
if(isset($_SESSION['user_id'])){
	$_SESSION = array();
    session_destroy();
    setcookie(session_name(),'',time()-3600);
    header('Location:http://localhost/SeniorYouth/');
    exit();
}
else if(isset($_SESSION['y_user_id'])){
	$_SESSION = array();
    session_destroy();
    setcookie(session_name(),'',time()-3600);
    header('Location:http://localhost/SeniorYouth/');
    exit();
}
else{
    header('Location:http://localhost/SeniorYouth/');
}


?>