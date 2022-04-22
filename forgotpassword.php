<?php

    include "config.php";

    if(isset($_POST['forgotemail'])){
        $femail = $_POST['forgotemail'];

        $sql =  "SELECT username FROM usersdata WHERE contactid = '{$femail}'";

        $result = mysqli_query($conn, $sql);

        if($result){
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);
                echo json_encode(array('error' => '0', 'res' => $row['username']));

            }else{
                echo json_encode(array('error' => '1', 'res' => "<div class='alert alert-warning m-0' role='alert'>User does not exist!</div>"));
            }
        }else{
            echo json_encode(array('error' => '2', 'res' => mysqli_error($conn)));
        }
    }

?>