
  
<?php

        include "config.php";
        session_start();
        if(!$_SESSION['id'])
        {
        include "config.php";
        header("Location: {$host}");
        }

        if(isset($_POST['text']))
        {
            $text = $_POST['text'];
            $stime =  date("g:i A, M j");
            $sql = "INSERT INTO messages(msg_id,msg,stime) VALUE({$_SESSION['id']},'{$text}','{$stime}')";
            if(mysqli_query($conn,$sql))
                echo "1";
            else
                echo "0";            
        }


?>