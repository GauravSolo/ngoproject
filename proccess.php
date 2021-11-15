<?php

    include "config.php";
    

    



    if(isset($_POST['payid']))
    {
        
        $payid = $_POST['payid'];
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];
        $ss = $_POST['ss'];


        if($ss == 'yes')
        {
            $sql = "SELECT user_id,username,contactid,role FROM usersdata WHERE contactid = '{$mail}'";
            if($result = mysqli_query($conn,$sql))
            {
                $rows = mysqli_fetch_assoc($result);

                session_start();

                $_SESSION['id'] = $rows['user_id'];
                $_SESSION['mailid'] = $rows['contactid'];
                $_SESSION['role'] = $rows['role'];
                $_SESSION['name'] = $rows['username'];

            }else{

                echo "couldnt run query --> pgresponse.php";
                die();

            }

        }

        $sql1 = "SELECT amount FROM donation WHERE email = '{$mail}'";
		

		$date = date('d M,Y');
		$ip = $_SERVER['REMOTE_ADDR'];

		if($result1 = mysqli_query($conn,$sql1))
		{

			if(mysqli_num_rows($result1) > 0)
			{
				$sql4 = "UPDATE usersdata SET money = money + {$amount} WHERE contactid = '{$mail}';";
              	$sql4 .= "UPDATE donation SET phone = '{$phone}',pay_id = '{$payid}',amount = amount + {$amount}, times = times + 1,date = '{$date}',ip = '{$ip}' WHERE email = '{$mail}'";
				if(mysqli_multi_query($conn,$sql4))
				{
						echo "update ok";

				}else{
					echo "mysqli_couldnt run query--> update d";
				}			
		    }else{

				$sql3 = "INSERT INTO donation(username,email,phone,status,pay_id,amount,times,date,ip) VALUES('{$name}','{$mail}','{$phone}','completed','{$payid}',{$amount},1,'{$date}','{$ip}')";

				if(mysqli_query($conn,$sql3))
				{
					$sql5 = "UPDATE usersdata SET money = money + {$amount} WHERE contactid = '{$mail}'";
					if(mysqli_query($conn,$sql5))
					{	
						echo "ok";
					}
				}else{
					echo "couldnt run query--> insert d";
				}
			}
		}else{
		
			echo "mysqli_ couldntru query--> update";
		}			
    }

?>