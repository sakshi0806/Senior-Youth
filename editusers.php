<?php
include './includes/preferences.php';

include HEADER;

if(filter_input(INPUT_POST,'delete')){
    $id = $_REQUEST['id'];
    $query = "DELETE FROM users WHERE user_id='".$id."'";
    // echo '<script> console.log("'.$id.'"); </script>';
    // echo $id;
    require_once PSQL;

    $stmt = pg_query($dbcl, $query);
    //header('Location:http://localhost/SeniorYouth/editusers.php');

    if(pg_affected_rows($stmt) == 1){
        echo "Deleted Successfully.";
        pg_close($dbcl);
    }
    else{
        $general_msg = '<p>System error occured, ypur account could not be registered. ' .$stmt->error;
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
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
            font-size: 25px;
            text-align: center;
        }

        table{
            width: 80%
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
                                else if(isset($_SESSION['y_user_id'])){
                                    echo $_SESSION['y_full_name'];
                                }
                                else{
                                    echo "Guest";
                                }
                            ?> 
                            </h1>
                            <h1>EDIT USERS</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Parallax Section -->
            <br><h2>Seniors</h2>
            <?php 
                require_once PSQL;
                $query = "SELECT * FROM users "; 
                $data = pg_query($dbcl, $query);
                //$data = pg_fetch_row($rs);
                
                $n = 0;
            ?>
            <br><table class='center'>
                <tr>
                    <th>User No</th>
                    <th>User</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Delete?</th>
                </tr>
            <?php
                while ($row = pg_fetch_row($data)) { 
                if($row[5] == 1){  
                $query1 = "SELECT * FROM senior_data WHERE user_id='$row[0]'"; 
                $data1 = pg_query($dbcl, $query1); 
                $row1 = pg_fetch_row($data1);
                $n++;
            ?>
                <td> <?php echo $n ?></td>
                <td>
            <?php
                if($row[4] == 1){
                    echo 'Admin';
                }
                else{
                    echo 'User';
                }
            ?>
                </td>
                <td><?php echo $row[1]  ?> </td>
                <td><?php echo $row1[2] ?> </td>
                <td><?php echo $row1[3] ?> </td>
                <td><?php echo $row[2]  ?> </td>
                <td><?php echo $row1[4] ?> </td>
                <td>
            <?php
                if($row[4] == 1){
                    echo '';
                }
                else{
            ?>
                <form action="editusers.php" method="post">
                <input type="hidden" name="id" value='<?php echo $row[0] ?>'>
                <button type="submit" name="delete" value="delete">Delete</button></form></td>
                <!-- <button  name="register" value="register">Register</button> -->
            <?php    
                }
            ?>
                </td>
                </tr>
            <?php
                }
            }
            ?>

            </table><br><br>

                <br><h2>Youth</h2>
            <?php 
                $query = "SELECT * FROM users "; 
                $data = pg_query($dbcl, $query);
                //$data = pg_fetch_row($rs);
                
                $n = 0;
            ?>
            <br><table class='center'>
                <tr>
                    <th>User No</th>
                    <th>User</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Delete?</th>
                </tr>
            <?php
                while ($row = pg_fetch_row($data)) { 
                if($row[5] == 2){  
                $query1 = "SELECT * FROM youth_data WHERE user_id='$row[0]'"; 
                $data1 = pg_query($dbcl, $query1); 
                $row1 = pg_fetch_row($data1);
                $n++;
            ?>
                <td> <?php echo $n ?></td>
                <td>
            <?php
                if($row[4] == 1){
                    echo 'Admin';
                }
                else{
                    echo 'User';
                }
            ?>
                </td>
                <td><?php echo $row[1]?> </td>
                <td><?php echo $row1[2]?> </td>
                <td><?php echo $row1[3]?> </td>
                <td><?php echo $row[2]?> </td>
                <td><?php echo $row1[4]?> </td>
                <td>
            <?php
                if($row[4] == 1){
                    echo '';
                }
                else{
            ?>
                <form action="editusers.php" method="post">
                <input type="hidden" name="id" value='<?php echo $row[0] ?>'>
                <button type="submit" name="delete" value="delete">Delete</button></form>
                </td>
            <?php    
                }
            ?>
                </td>
                </tr>
            <?php
                }
            }
            ?>
            
            </table><br><br>


            <?php    
                pg_close($dbcl); 
            ?>
</html>
