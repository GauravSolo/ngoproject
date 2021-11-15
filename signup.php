<?php
header('Access-Control-Allow-Origin: *');

  include 'config.php';
  session_start();
  
     if(isset($_POST['inputusername']))
    {
      $uname = $_POST['inputusername'];
      $uemail = $_POST['inputemail'];
      $upassword = $_POST['inputpassword'];
      $ucity = $_POST['select'];
      $umoney = 0;
      $urole = 0;
      $uaddress = $_SERVER['REMOTE_ADDR'];
      date_default_timezone_set('Asia/Kolkata'); 

      $udate = date('d M,Y');
      $error = "something went wrong!";

      function isValidEmail($uemail){ 
          return filter_var($uemail, FILTER_VALIDATE_EMAIL) !== false;
      }

      function validate_mobile($uemail)
      {
          return preg_match('/^[0-9]{10}+$/', $uemail);
      }

      if(!isValidEmail($uemail) && !validate_mobile($uemail))
      {
        $error =  "<div class='alert alert-warning m-0 p-0' role='alert'>Please enter valid email or phone!<div>";
        echo json_encode(array('res'=>$error));
        die();
      }
      ini_set('memory_limit', '-1');
            if($_FILES['profilepic']['size'] == 0)
            {
              
              $image_name = 'user.svg';
            }else{
              $file_name = $_FILES['profilepic']['name'];
              $file_size = $_FILES['profilepic']['size'];
              $file_tmp = $_FILES['profilepic']['tmp_name'];
              $file_type = $_FILES['profilepic']['type'];
              $file_ext = strtolower(end(explode('.',$file_name)));
              $extension = array('jpeg','jpg','png','svg');

              $error = "";

              if(in_array($file_ext,$extension) === false)
              {
                $error =  "<div class='alert alert-danger m-0 p-0' style='font-size:20px;background-color:tomato;' role='alert'>This extension file not allowed. Please choose a PNG,JPG or SVG!</div>";
                echo json_encode(array('res'=>$error));
                die();
              }

              if($file_size > 10000000)
              {
                $error =  "<div class='alert alert-danger m-0 p-0' style='font-size:20px;background-color:tomato;' role='alert'>File size must be 10mb or lower!</div>";
                echo json_encode(array('res'=>$error));
                die();
                
              }
              
              if($file_size > 1000000)
              {
                if($file_type == 'image/jpeg')
                {
                  $img = imagecreatefromjpeg($file_tmp);
                }elseif($file_type == 'image/png'){
                  $img = imagecreatefrompng($file_tmp);
                }
                
                  if($file_type == 'image/jpeg' || $file_type == 'image/png' ){
                        $exif = exif_read_data($_FILES['profilepic']['tmp_name']);
                        if (!empty($exif['Orientation'])) {
                             // provided that the image is jpeg. Use relevant function otherwise
                            switch ($exif['Orientation']) {
                                case 3:
                                $img = imagerotate($img, 180, 0);
                                break;
                                case 6:
                                $img = imagerotate($img, -90, 0);
                                break;
                                case 8:
                                $img = imagerotate($img, 90, 0);
                                break;
                                default:
                                $img = $img;
                            } 
                        }
                  }
                
                if(isset($img)){
                  imagejpeg($img,$file_tmp,30);
                }
              }

              $new_name = time().'-'.basename($file_name);
              $image_name = $new_name;
              $target = "";
              if($error == "")
              {
                $target = "upload/". $image_name;
                move_uploaded_file($file_tmp,$target);
              }
              else{
                $error = "<div class='alert alert-danger m-0 p-0' style='font-size:20px;background-color:tomato;' role='alert'>Something went wrong in uploading image!</div>";
              }
          }
   

            $sql = "SELECT contactid FROM usersdata WHERE contactid = '{$uemail}'";
            $result = mysqli_query($conn,$sql) or die('couldnt run query');
            
            if(mysqli_num_rows($result) > 0)
            {
              $error = "<div class='alert alert-warning m-0 p-0' style='font-size:20px;background-color:yellow;' role='alert'>This user already exists!</div>";
            }
            else
            {
               $sql1 = "SELECT amount FROM donation WHERE email = '{$uemail}'";
               
              if($result1 = mysqli_query($conn,$sql1))
              {
                if(mysqli_num_rows($result1) > 0)
                {
                  $row1 = mysqli_fetch_assoc($result1);
                  $umoney = $row1['amount'];
                  
                  $sql = "INSERT INTO usersdata(username,password,contactid,address,city,money,role,date,image) VALUE('{$uname}','{$upassword}','{$uemail}','{$uaddress}','{$ucity}',{$umoney},{$urole},'{$udate}','{$image_name}');";
                  
                }else{
                  
                  $sql = "INSERT INTO usersdata(username,password,contactid,address,city,money,role,date,image) VALUE('{$uname}','{$upassword}','{$uemail}','{$uaddress}','{$ucity}',{$umoney},{$urole},'{$udate}','{$image_name}');";
                  $sql .= "INSERT INTO donation(username,email,phone,status,pay_id,amount,times,date,ip) VALUES('{$uname}','{$uemail}','empty','completed','empty',{$umoney},0,'{$udate}','{$uaddress}')";
                  
                }
              }
              
             
                $result = mysqli_multi_query($conn,$sql) or die("couldnt run query --> signup form");
                
                if($result)
                {
                  $error = "<div class='alert alert-success m-0 p-0' style='font-size:18px;' role='alert'>You've successfully signed up! Now do login!</div>";
                  mysqli_close($conn);
                }
                
            }
            echo json_encode(array('res'=>$error));

          }else{
          
            echo json_encode(array('res'=>"no data"));

          }
    

?>
