<?php
    error_reporting(E_ALL);
    include("../model/MyDiary.php");

    $firstname = $lastname = $username = $password = $cpassword = $exist = "";
    if(isset($_POST["btnregister"]))
    {
        $lastname = trim($_POST["lastname"]);
        $firstname = trim($_POST["firstname"]);
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $cpassword = trim($_POST["cpassword"]);

        if(!empty($lastname) && !empty($firstname) && !empty($username) && !empty($password) && !empty($cpassword))
        {   
            if(strlen($password) >= 8)
            {
                //if username is taken
                $result = $Diary->user_Owner($username);
                if($row = mysqli_fetch_array($result))
                {
                    $exist = $row[3];
                }
                //if username is unique
                if($exist != $username)
                {
                    if($password == $cpassword)
                    {
                        $encryptpass = md5($password);
                        $Diary->add_Owner($lastname,$firstname,$username,$encryptpass);
                        header("Location: ../view/register.php?register=successful");
                        exit;
                    } else {
                        header("Location: ../view/register.php?password=incorrect&firstname={$firstname}&lastname={$lastname}&username={$username}");
                        exit;
                    }
                } else {
                    header("Location: ../view/register.php?user=exist&firstname={$firstname}&lastname={$lastname}&username={$username}");
                    exit;
                }
            } else {
                header("Location: ../view/register.php?password=tooshort&firstname={$firstname}&lastname={$lastname}&username={$username}");
                exit;
            }
        } else {
            header("Location: ../view/register.php?fields=required&firstname={$firstname}&lastname={$lastname}&username={$username}");
            exit;
        }
    }

?>