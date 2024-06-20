<?php
include './includes/preferences.php';

include HEADER;

require_once PSQL;
if(filter_input(INPUT_POST,'submit')){
    $errors = array();
    $msg = array();
    $c = FALSE;
    if(between($_POST['message'],6,255)){
		$c = pg_escape_string($_POST['message']);
	}
	else{
		$errors['message'] = 'Message should be within 6-255 characters';
	}

    if($c){
        $date = date('Y-m-d');
        $query = "INSERT INTO forum(date, user_id, contents) VALUES ('$date', '".$_SESSION['user_id']."', '$c')";
		$stmt = pg_query($dbcl, $query);

			if(pg_affected_rows($stmt)){
				$msg['message'] = 'Your message is posted successfully.';
                header('Location:http://localhost/SeniorYouth/forum.php');
                // if(isset($_SESSION['msg'])){
                //     echo $_SESSION['msg'];
				// 	unset($_SESSION['msg']);
				// }
    }

}
// pg_close($dbcl);
}

if(isset($_REQUEST['delete'])){
    $msg = array();
    $query = "DELETE FROM forum WHERE forum_id=".$_REQUEST['id']."";
    //echo '<script> console.log("'.$query.'"); </script>';
     $stmt = pg_query($dbcl, $query);
     
      if(pg_affected_rows($stmt) == 1){
        $msg['message'] = 'Message Deleted Successfully';
         //     pg_close($dbcl);
          }
          else{
                  $msg['message'] = 'Message could not be deleted. Please Try Again!.';
         }
             header('Location:http://localhost/SeniorYouth/forum.php');
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
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
            font-size: 25px;
            text-align: center;
        }

        table{
            width: 90%;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .forum{
            width:70%;
            padding :30px;
            border :3px solid #ebebeb;
            border-radius : 10px;
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
            border: 1px solid #1abc9c;
            background-color: #1abc9c;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            }


            button:active {
                transform: scale(0.95);
            }

            button:focus {
                outline: none;
            }

            button:hover{
                cursor: pointer;
                background-color : white;
                color: #1abc9c;
            }

            button.ghost {
                background-color: transparent;
                border-color: #FFFFFF;
            }

            th{
                /* background-color :#57c9b2; */
                background: linear-gradient(to right, #31d3b3, #1abc9c); */
                color: #FFFFFF;
                
            }

            h2{
                margin: 20px;
                text-align: center;
            }

            h1{
                color:white !important;
            }

            .dforum{
                background-color: #99f5e2;
                width: 70%;
                margin-top:30px;
                margin-bottom:30px;
                border-radius:10px;
                padding:20px;
                
            }

            .mes{
                font-size:20px;
                margin:5px 20px 5px;
            }

            .name{
                font-size:17px;
                margin:5px 20px 5px;
            }

            .date{
                font-size:15px;
                margin:5px 20px 5px;
            }



    </style>
    </head>

    <!-- HOME Section -->
    <div class="parallax-section parallax1">
                <div class="grid grid-pad">
                    <div class="col-1-1">
                         <div class="content content-header" >
                            <br>
                            <h1>Welcome 
                            <?php
                                if(isset($_SESSION['user_id'])){
                                    echo $_SESSION['full_name'];
                                }
                                else{
                                    echo "Guest";
                                }
                            ?> 
                            </h1>
                            <h1>FORUMS</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Parallax Section -->
            <br><br>
            <!-- <form action="" method="post"> -->
            <?php echo isset($msg['message'])?$msg['message']:''; ?>
                <form action="forum.php" method="post">
                    <?php // echo isset($_SESSION['msg'])?$_SESSION['msg']:''; ?>
                    
                    <div class="center forum">
                            <h5>Full Name</h5>
                            <input type="text" name="name" placeholder="Full Name" value="<?php echo $_SESSION['full_name']?>">
                            
                            <h5>Message</h5>
                            <span>
                                <?php echo isset($errors['message'])?$errors['message']:''; ?>
                            </span>

                            <textarea name="message" id="message" palceholder="Type your Message" cols="0" rows="0"></textarea>                           

                            <button type="submit" name="submit" value="submit">Submit</button>
                    </div>

                </form>
            
                
            
            <br><br>
            <h2>Forum Messages</h2><br>
            <?php
                require_once PSQL;
                $query = "SELECT * FROM forum";
		        $data = pg_query($dbcl, $query);
                if(pg_num_rows($data) == 0){
                    echo "<h4 class='dforum center'>No Messages Posted Yet</h4>";
                }
                while ($row = pg_fetch_row($data)) {
                    $query2 = "SELECT * FROM users WHERE user_id='".$row[2]."'";
		            $data2 = pg_query($dbcl, $query2);
                    $row2 = pg_fetch_row($data2);
                    // echo '<script> console.log("'.$row2[0].'"); </script>';
                      ?>
                    <div class="dforum center">
                        <div class="name"><?php 
                        //echo '<script> console.log("'.$row2[5].'"); </script>';
                        if($row2[5] == 1){
                            $query1 = "SELECT first_name, last_name FROM senior_data WHERE user_id='".$row[2]."'";
                            $data1 = pg_query($dbcl, $query1);
                            $row1 = pg_fetch_row($data1);

                            $fn=$row1[0].' '.$row1[1];
                        }
                        else if($row2[5] == 2){
                            $query1 = "SELECT y_first_name, y_last_name FROM youth_data WHERE user_id='".$row[2]."' limit 1";
                            $data1 = pg_query($dbcl, $query1);
                            $row1 = pg_fetch_row($data1);
                            $fn=$row1[0].' '.$row1[1];
                            //echo '<script> console.log("'.$row1[2].'"); </script>';
                        }
                        echo $fn;
                        ?></div>
                        <div class="mes">
                            <?php echo $row[3]?>

                        </div>
                        <div class="date">
                            <?php echo "Posted on : ".$row[1]?>
                        </div>

                        <?php
                            if($row[2] == $_SESSION['user_id']){
                        ?>
                                <form action="" method="post">
                                <input type="hidden" name="id" value='<?php echo $row[0] ?>'>
                                <button type="submit" name="delete" value="delete">Delete</button></form></td>
                        <?php    
                            }
                            else{
                                echo '';
                            }
                        ?>


                    </div>

                    <?php
                }
                pg_close($dbcl);
            ?>

</script>
</html>