<?php

    include "config.php";

    if(isset($_POST['otp'])){
        $otp = $_POST['otp'];

        $sql =  "SELECT * FROM otp WHERE otp = $otp AND is_expired != 1 AND now() <= DATE_ADD(otp_date, INTERVAL 5 MINUTE)";

        $result = mysqli_query($conn, $sql);

        if($result){
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);
                while(mysqli_next_result($conn)){;}

                $sql =  "UPDATE otp SET is_expired = 1 WHERE otp_id = {$row['otp_id']}";
                if(mysqli_query($conn, $sql))
                {

                }
                while(mysqli_next_result($conn)){;}
                
                $sql = "SELECT user_id,username,contactid,role FROM usersdata WHERE contactid = '{$row['user_email']}'";
                $result = mysqli_query($conn,$sql) or die("couldnt run query");
                if(mysqli_num_rows($result) > 0)
                {
                    $rows = mysqli_fetch_assoc($result);

                    session_start();

                    $_SESSION['id'] = $rows['user_id'];
                    $_SESSION['mailid'] = $rows['contactid'];
                    $_SESSION['role'] = $rows['role'];
                    $_SESSION['name'] = $rows['username'];

                    echo json_encode(array('error' => '0', 'res' => "<div class='alert alert-success m-0' role='alert'>Hi, {$row['username']}!<br/>You've successfully logged in.</div>"));

                }else{
                    echo json_encode(array('error' => '3', 'res' => "<div class='alert alert-danger m-0' role='alert'>Hi, {$row['username']}!<br/>You can't log in.Try After some time!</div>"));
                }


            }else{
                echo json_encode(array('error' => '1', 'res' => "<div class='alert alert-danger m-0' role='alert'>OTP is wrong !</div>"));
            }
        }else{
            echo json_encode(array('error' => '2', 'res' => mysqli_error($conn)));
        }
    }

?>