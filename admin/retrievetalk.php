<?php

        include "config.php";
        session_start();
        if(!$_SESSION['id'])
        {
            include "config.php";
            header("Location: {$host}");
        }

            $tpost = $_POST['tpost'];
            $sql = "SELECT messages.sno,messages.msg_id,messages.msg,messages.stime,usersdata.username,usersdata.image FROM messages INNER JOIN usersdata ON messages.msg_id = usersdata.user_id ORDER BY messages.sno ASC";
            $result = mysqli_query($conn,$sql) or die("couldnt ru query");
            $res = "";
            

            if($result)
            {

                if(mysqli_num_rows($result) > 0)
                {
                    if($tpost == mysqli_num_rows($result))
                    {
                        $bottom = '0';
                    }else{
                        $bottom = '1';
                    }

                    while($row = mysqli_fetch_assoc($result))
                    {
                        if($_SESSION['role']){
                            $deletebtn = '<button class="delete float-end" style="border:none; background:darkgrey; margin-top:-25px; z-index:10;font-size:20px;width:50px;height:50px;" data-id="'.$row['sno'].'" ><a href="#"  data-id="'.$row['sno'].'"><i  data-id="'.$row['sno'].'" class=
                            "fa  fa-trash"></i></a></button>';
                        }else{
                            $deletebtn = "";
                        }
                        if($row['msg_id'] == $_SESSION['id'])
                        {
                            $active = "class='right'";
                            $times = "class='time-left'";
                            $darker = "darker";
                            $float = "float:right;";
                        }
                        else{
                            $darker = "";
                            $active = "";
                            $float = "float:left;";
                            $times = "class='time-right'";
                        }
                        if($row['msg_id'] == 1)
                        {
                            $admin = '<span class="badge bg-secondary">Admin</span>';
                        }else{
                            $admin = "";
                        }
                        $res = $res.'<div class="msgcontainer '.$darker.'"><span style="'.$float.' display: flex;flex-direction: column;width:78px;justify-content: center;align-items: center;">
                        <img class="me-0" src="../upload/'.$row['image'].'" '.$active.'alt="Avatar"><span style="overflow: hidden;text-overflow: ellipsis;display: flex;text-align: center;height: 30px;overflow:hidden;text-overflow:ellipsis;font-size:14px;font-weight:bold;color:lightseagreen;text-transform:capitalize;" >'.strtolower(explode(" ",$row["username"])[0]).'</span></span>
                        <p>'.$row['msg'].' '.
                        $admin.'</p>'.$deletebtn.'
                        <span '.$times.'>'.$row['stime'].'</span>
                      </div>';
                    }
                    echo json_encode(array('res'=>$res,'bottom'=>$bottom));
                }
            }
            else
            {
                echo "cant run query";
            }
?>