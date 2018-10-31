<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }

    $owner_id = $_SESSION["owner_id"];
    $firstname = $lastname = $username = $alias = "";
    if(isset($_POST["saveprofile"]))
    {
        $firstname = $_POST["nFirstname"];
        $lastname = $_POST["nLastname"];
        $username = $_POST["nUsername"];
        $alias = $_POST["nAlias"];
        $exist = "";
        if(!empty($firstname) && !empty($lastname) && !empty($username))
        {
            $result = $Diary->notuser_Owner($username,$owner_id);
            if($row = mysqli_fetch_array($result))
            {
                $exist = $row[4];
            }
            //if username is unique
            if($exist != $username)
            {
                $Diary->update_Owner($firstname,$lastname,$alias,$username,$owner_id);
                header("Location: ../view/settings.php?profile=updated");
                exit;
            } else {
                //header("Location: ../view/settings.php?newuser=exist");
                exit;
            }
            
        } else {
            header("Location: ../view/settings.php?profile_fields=empty");
            exit;
        }
    }
    if(isset($_POST["saveimage"]))
    {
        $picture_tmp = $_FILES['image']['tmp_name'];
        $picture_name = $_FILES['image']['name'];
        $picture_type = $_FILES['image']['type'];
        $path = "";
        $allowed_type = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg');
        if(in_array($picture_type, $allowed_type)) {
            $path = '../view/images/userpic/'.$picture_name; //change this to your liking
            move_uploaded_file($picture_tmp, $path);
        }

        $result = $Diary->picture_Owner($path,$owner_id);
        if($result)
        {
            header("Location: ../view/settings.php?profile=updated");
            exit;
        }
    }

    if(isset($_POST["savepass"])){
        $sqlpass = "";
        $currpass = $_POST["oPassword"];
        $newpass = $_POST["nPassword"];
        $confirmpass = $_POST["cnPassword"];
        $encryptcurr = md5($currpass);
        $encryptnew = md5($newpass);
        $dpass = $Diary->selpass_Owner($owner_id);
        foreach($dpass as $p)
        {
            $sqlpass = $p["owner_password"];
        }
        if(!empty($currpass) && !empty($newpass) && !empty($confirmpass))
        {
            if($sqlpass == $encryptcurr)
            {
                if($newpass == $confirmpass)
                {
                    $Diary->changepass_Owner($encryptnew,$owner_id);
                    header("Location: ../view/settings.php?password_change=success");
                    exit;
                } else {
                    header("Location: ../view/settings.php?confirm_password=failed");
                    exit;
                }
            } else {
                header("Location: ../view/settings.php?current_password=incorrect");
                exit;
            }
        } else {
            header("Location: ../view/settings.php?password_fields=empty");
            exit;
        }
    }

?>