<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['mail']))
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = "587";                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('');
        // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress("{$_POST['mail']}");               //Name is optional
        // $mail->addReplyTo('25802582ls@gmail.com');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'OTP';
        $otp = rand(100000,999999);
        $mail->Body    = "
                            <div style=\"font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2\">
                              <div style=\"margin:50px auto;width:70%;padding:20px 0\">
                                <div style=\"border-bottom:1px solid #eee\">
                                  <a href=\"\" style=\"font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600\">FreeNGO</a>
                                </div>
                                <p style=\"font-size:1.1em\">Hi, <b>{$_POST['username']}</b></p>
                                <p>Thank you for choosing FreeNGO. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
                                <h2 style=\"background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;\">$otp</h2>
                                <p style=\"font-size:0.9em;\">Regards,<br />FreeNGO</p>
                                <hr style=\"border:none;border-top:1px solid #eee\" />
                                <div style=\"float:right;padding:8px 0;color:#aaa;font-size:1em;line-height:1;font-weight:300\">
                                  <p>Gaurav Sharma</p>
                                  <p>India</p>
                                </div>
                              </div>
                            </div>";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if($mail->send())
          {
            include 'config.php';
            
            $sql = "INSERT INTO otp(user_email,username,otp,is_expired,otp_date) VALUES('{$_POST['mail']}','{$_POST['username']}',$otp,0,now())";
            if(mysqli_query($conn, $sql))
            {
              echo json_encode(array('error' => '0', 'res' => "<div class='alert alert-success m-0' role='alert'>OTP has sent!</div>"));
            }else{
              echo json_encode(array('error' => '3', 'res' => "<div class='alert alert-danger m-0' role='alert'>Coudnt insert otp !</div>"));
            }

          }
        else
          echo json_encode(array('error' => '1', 'res' => "<div class='alert alert-danger m-0' role='alert'>Something Went Wrong! Couldnt send OTP</div>"));
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo json_encode(array('error' => '2', 'res' => "<div class='alert alert-danger m-0' role='alert'>Something Went Wrong! {$mail->ErrorInfo}</div>"));
    }
}

?>