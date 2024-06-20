<?php
include './includes/preferences.php';

include HEADER;

require_once PSQL;
if(filter_input(INPUT_POST,'available')){
    if($_SESSION['role_id'] == 1){
        $query = "UPDATE senior_data SET help='1' WHERE user_id='".$_SESSION['user_id']."' ";
        $data = pg_query($dbcl, $query);
    }
    else if($_SESSION['role_id'] == 2){
        $query = "UPDATE youth_data SET help='1' WHERE user_id='".$_SESSION['user_id']."' ";
        $data = pg_query($dbcl, $query);
        }
        $_SESSION['status'] = 'Available';
}

if(filter_input(INPUT_POST,'navailable')){
    if($_SESSION['role_id'] == 1){
        $query = "UPDATE senior_data SET help='0' WHERE user_id='".$_SESSION['user_id']."' ";
        $data = pg_query($dbcl, $query);
    }
    else if($_SESSION['role_id'] == 2){
        $query = "UPDATE youth_data SET help='0' WHERE user_id='".$_SESSION['user_id']."' ";
        $data = pg_query($dbcl, $query);
        }

        $_SESSION['status']  = 'Not Available';
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
            /* background-color: #1abc9c; */
            background-color: transparent;
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

            h3{
                text-align:center;
            }

            .buttons{
                width:30%;
            }

            .dforum{
                background-color: #99f5e2;
                width: 70%;
                margin-top:30px;
                margin-bottom:30px;
                border-radius:10px;
                padding:20px;
                
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
                            <h1>Helping Dome</h1>
                            <?php
                                if($_SESSION['role_id'] == 2){  ?>
                                <form method="post">
                            <button type="submit" name="available" value="avail">Available</button>
                            <button type="submit" name="navailable" value="avail">Not Available</button>
                            </form>
                            <h3>Current Status : <?php 
                                require_once PSQL;
                                    $query = "SELECT help FROM  youth_data WHERE user_id='".$_SESSION['user_id']."' ";
                                    $data = pg_query($dbcl, $query);
                                    $row = pg_fetch_row($data);
                                    if($row[0] == 0){
                                        echo "Not Available";
                                    }
                                    else if($row[0] == 1){
                                        echo "Available";
                                    }
                            
                            ?></h3>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Parallax Section -->
            <br>
            <!-- <form action="" method="post"> -->
                <form action="helpingdome.php" method="post">
                    <div class="center">
                    
                        <?php 
                        if($_SESSION['role_id'] == 1){
                            echo "";
                        }
                        else if($_SESSION['role_id'] == 2){
                            ?>
                            <!-- <div class=" buttons center"> -->
                            <!-- <button type="submit" name="available" value="avail">Available</button>
                            <button type="submit" name="navailable" value="avail">Not Available</button> -->
                            
                            </div>
                           <?php }
                        ?>
                    
                    </div>
                </form>
            <!-- </form> -->
            <?php 
                require_once PSQL;
                
                if(isset($_SESSION['user_id'])){
                    if($_SESSION['role_id'] == 1){
                        $query = "SELECT * FROM youth_data WHERE help='1'";
                        $data = pg_query($dbcl, $query);
                        if(pg_num_rows($data) == 0){
                            echo "<h3 class='dforum center'>No Users Available.</h3>";
                        }else{
                        ?>
                            <h2>Users Available to Help</h2>
                            <table class="center"><tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <tr>
                            <?php
                            
                            while($row1 = pg_fetch_row($data)) {
                                
                                    $query1 = "SELECT * FROM users WHERE user_id='$row1[0]'";
                                    $data1 = pg_query($dbcl, $query1);
                                    $row = pg_fetch_row($data1);
                                ?>

                                <td> <?php echo $row[1] ?></td>
                                <td> <?php echo $row1[2].' '.$row1[3] ?></td>
                                <td> <?php echo $row1[4] ?></td>
                                <td> <?php echo $row[2] ?></td></tr>
                                <?php
                                }
                            }  ?> </table><br><br> <?php
                    }
                }
                    // else if($_SESSION['role_id'] == 2){
                    //     $query = "SELECT * FROM senior_data WHERE help='1'";
                    ?>
                    <!-- <h2>Seniors who need Help</h2>
                    <table  class="center"><tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <tr> -->
                    <?php
                    // $data = pg_query($dbcl, $query);
                    // while($row1 = pg_fetch_row($data)) {
                    //     $query1 = "SELECT * FROM users WHERE user_id='$row1[0]'";
                    //     $data1 = pg_query($dbcl, $query1);
                    //     $row = pg_fetch_row($data1);
                    ?>

                    <!-- <td> <?php //echo $row[1] ?></td>
                    <td> <?php //echo $row1[2].' '.$row1[3] ?></td>
                    <td> <?php //echo $row1[4] ?></td>
                    <td> <?php //echo $row[2] ?></td></tr></table> -->
                    <?php
                        //}  
                    //}
                ?>
                
                 <!-- // if(isset($_SESSION['user_id'])){ 
                //     $query = "SELECT * FROM youth WHERE free='1'"; 
                // }
                // else if(isset($_SESSION['y_user_id'])){ 
                //     $query = "SELECT * FROM users WHERE help='1'"; 
                // }
                // $data = pg_query($dbcl, $query);
                // //$data = pg_fetch_row($rs);
                // $row = pg_fetch_row($data);
                // $n=0; -->
            <?php    
                pg_close($dbcl); 
            ?>
            
            <!-- <script>


function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.innerHTML === "Available") {
    x.innerHTML = "Not Available";
  } else {
    x.innerHTML = "Available";
  }
}


</script> -->
</html>

<!-- function myFunction() {
  var x = document.getElementById("myDIV");

  
  if (x.innerHTML === "Available") {
    x.innerHTML = "Not Available";
    // <?php 
    //     $query = "UPDATE youth_id SET help='0' WHERE user_id='".$_SESSION['user_id']."' ";
    //     $data = pg_query($dbcl, $query);
    // ?>
  } else {
    x.innerHTML = "Available";
    // <?php
    // $query = "UPDATE youth_id SET help='1' WHERE user_id='".$_SESSION['user_id']."' ";
    //     $data = pg_query($dbcl, $query);
    // ?>
  }
} -->