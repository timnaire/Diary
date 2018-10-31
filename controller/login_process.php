<?php
    include("../model/MyDiary.php");
    $username = $password = "";
    if(isset($_POST["btnlogin"]))
    {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $encryptpass = md5($password);
        if(!empty($username))
        {
            if(!empty($password))
            {
                $result = $Diary->exist_Owner($username,$encryptpass);
                //if username and password matched, then get result and head to index.php
                if($row = mysqli_fetch_array($result))
                {
                    $_SESSION["owner_id"] = $row[0];
                    if(!empty($_POST["rememberme"])) {
                        echo $_POST["rememberme"];
                        setcookie ("member_user",$username,time()+ (10 * 365 * 24 * 60 * 60), "/");
                        setcookie ("member_pass",$password,time()+ (10 * 365 * 24 * 60 * 60), "/");
                    } else {
                        cookieunset("member_user","member_pass");
                    }
                    header("Location: ../view/index.php");
                    exit;
                } else { 
                    //if not matched then give description
                    //unset cookie using unsetcookie function
                    cookieunset("member_user","member_pass");
                    if(!empty($_POST["rememberme"])) {
                        $errmem = "checked";
                    }
                    header("Location: ../view/login.php?account=not_exist&username={$username}&remember={$errmem}");
                    exit;
                }
            } else {
                if(!empty($_POST["rememberme"])) {
                    $errmem = "checked";
                }
                header("Location: ../view/login.php?username={$username}&password=empty&remember={$errmem}");
                exit;
            }
        } else {
            if(!empty($_POST["rememberme"])) {
                $errmem = "checked";
            }
            header("Location: ../view/login.php?credentials=required&remember={$errmem}");
            exit;
        }

    }

    function cookieunset($member_user,$member_pass){
        if(isset($member_user)) {
            setcookie ($member_user,"", time() - 3600, "/");
        }
        if(isset($member_pass)) {
            setcookie ($member_pass,"", time() - 3600, "/");
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>