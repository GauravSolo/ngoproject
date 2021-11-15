<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

include "../config.php";

$ss = $_GET['ss'];
$mail = $_GET['mail'];
$name = join(" ",explode("_",$_GET['name']));

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

}else{


}


if($isValidChecksum == "TRUE") {
	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	$amount = $_POST['TXNAMOUNT'];
	
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		
		$sql1 = "SELECT amount FROM donation WHERE email = '{$mail}'";
		
		$times = 1;
		$date = date('d M,Y');
		$ip = $_SERVER['REMOTE_ADDR'];

		if($result1 = mysqli_query($conn,$sql1))
		{

			if(mysqli_num_rows($result1) > 0)
			{
				$sql2 = "UPDATE donation SET amount = amount + {$amount}, times = times + 1,date = '{$date}',ip = '{$ip}' WHERE email = '{$mail}'";
				if(mysqli_query($conn,$sql2))
				{
					
					$sql4 = "UPDATE usersdata SET money = money + {$amount} WHERE contactid = '{$mail}'";
					if(mysqli_query($conn,$sql4))
					{	
						echo "ok";
					}

				}else{
					echo "mysqli_couldnt run query--> update d";
				}			
			}else{

				$sql3 = "INSERT INTO donation(username,email,status,amount,times,date,ip) VALUES('{$name}','{$mail}','TXN_SUCCESS',{$amount},{$times},'{$date}','{$ip}')";
				echo $sql3;
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
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";

		
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>