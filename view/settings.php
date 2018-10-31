<?php
    include("../model/MyDiary.php");
    date_default_timezone_set('Asia/Manila');
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: login.php");
        exit;
    }
    $owner_id = $_SESSION["owner_id"];
    $date = date("Y-m-d");
    $result = $Diary->fetch_Owner($owner_id);
    if($row = mysqli_fetch_row($result))
    {
        $_SESSION["lastname"] = $lastname = $row[1];
        $_SESSION["firstname"] = $firstname = $row[2];
        $_SESSION["alias"] = $username = $row[3];
        $_SESSION["username"] = $username = $row[4];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Settings - Diary</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="materialize/fonts.googleapis.com/icon_family-material+Icons.css">
        <link rel="stylesheet" href="materialize/css/materialize.css">
        <link rel="stylesheet" href="materialize/css/custom.css">
        <link rel="icon" href="images/icon.ico">
    </head>
    <body class="blue-grey lighten-5">
        
        <div class="row z-depth-1 white">
            <div class="container">
                <div class="col s10 m8 l6">        
                    <ul>
                        <li><a href="index.php"><i class="material-icons waves-effect scale-transition">home</i><span class="menu">Home</span></a></li>
                        <li><a  href="diary.php"><i class="material-icons waves-effect scale-transition">book</i><span class="menu">Diary</span></a></li>
                    </ul>
                </div>
                <div class="col s2 m4 l6 right">
                    <span class="menu-pic" style="float:right;">
                    <a href="#" class="notifyDrop">
                    <span class="badge left" style="position:relative;top:3px;left:5px;">
                        <?php 
                            $bdg = $Diary->ttlnotification($owner_id);
                            if($bdg)
                            {
                                foreach($bdg as $b){
                                    if($b['ttlnoti'] == '0'){
                                        echo "";
                                    } else {
                                        echo $b['ttlnoti'];
                                    }
                                }
                            }
                        ?>
                    </span>
                        <i class="material-icons">notifications</i>
                    </a>

                    <div class="prompt z-depth-2">
                        <h6 class="center">Notification</h6>
                        <ul class="collection" style="margin:0 0 0 0 !important;">
                            <?php
                                $seen = date("Y-m-d g:i");
                                $Diary->seen($owner_id,$seen);
                                $noti = $Diary->receive_Notification($owner_id);
                                if($noti)
                                {
                                    foreach($noti as $n)
                                    {
                                        if(empty($n['time_seen'])){
                                    ?>
                                            <li class="collection-item avatar" style="width:100%;">
                                            <?php
                                        } else {
                                            echo "<li class='collection-item avatar' style='width:100%;background-color:#f5f5f5'>";
                                        }
                                        if($n['owner_img'])
                                        {
                                            echo "<img src='{$n['owner_img']}' alt='profile-picture' class='circle'>";
                                        } else {
                                            echo "<img src='images/default_user_img.png' alt='profile-picture' class='circle'>";
                                        }
                                        ?>
                                        <p><i style="color:#4fc3f7" class="tiny material-icons">thumb_up</i> Likes your story - <?php echo $n['story_title']; ?></p>
                                        <p style="font-size:0.7em;">Date: <?php echo date("M j, Y g:i a", strtotime("{$n['time_unseen']}")); ?></p>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    echo "<div class='center'>Nothing</div>";
                                }
                            ?>
                            <a href="#">
                                <li class="collection-item center" style="width:100%">  
                                    <span>More</span>
                                </li>
                            </a>
                        </ul>
                    </div>
                        <?php
                            $result = $Diary->fetch_Owner($owner_id);
                            if($row = mysqli_fetch_row($result))
                            {
                                if(empty($row[6]))
                                echo "<img style='border:2px solid #4fc3f7' class='dropdown-trigger' data-target='picmenu' src='images/default_user_img.png' width='30px' height='30px' alt='my-profile-pic'>";
                                else
                                echo "<img style='border:2px solid #4fc3f7' class='dropdown-trigger' data-target='picmenu' src='{$row[6]}' width='30px' height='30px' alt='my-profile-pic'>";
                            }
                        ?>
                    </span>

                    <!-- Dropdown Structure -->
                    <ul id='picmenu' class='dropdown-content'>
                        <li><a href="settings.php">Settings</a></li>
                        <li><a href="../controller/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12 l12 m6 push-m3 center white z-depth-1 scale-transition scale-out" id="setting-content">
                    <div class="row"></div>
                    <?php include("includes/alert.php"); ?>
                    <button class="btn waves-effect waves-light light-blue lighten-2" id="pbtn">Profile Setting</button>
                    <button class="btn waves-effect waves-light light-blue lighten-2" id="ibtn">Change Picture</button>
                    <button class="btn waves-effect waves-light light-blue lighten-2" id="cbtn">Change Password</button>
                    <div class="row">
                        <!-- CHANGE PROFILE -->
                        <div class="col s12 m12 l4 push-l4 scale-transition scale-out" id="profile-setting">
                            <form action="../controller/save_profile_process.php" method="POST">

                                <blockquote style="border-left:5px solid #4fc3f7;"><b>Profile Setting</b></blockquote>
                                <div class="input-field">
                                    <input id="nFirstname" name="nFirstname" type="text" value="<?php echo $_SESSION['firstname']; ?>">
                                    <label for="nFirstname">Firstname</label>
                                </div>
                                <div class="input-field">
                                    <input id="nLastname" name="nLastname" type="text" value="<?php echo $_SESSION['lastname']; ?>">
                                    <label for="nLastname">Lastname</label>
                                </div>
                                <div class="input-field">
                                    <input id="nAlias" name="nAlias" type="text" value="<?php echo $_SESSION['alias']; ?>">
                                    <label for="nAlias">Alias</label>
                                </div>
                                <div class="input-field">
                                    <input id="nUsername" name="nUsername" type="text" value="<?php echo $_SESSION['username']; ?>">
                                    <label for="nUsername">Username</label>
                                </div>
                                <button class="btn waves-effect waves-light light-blue lighten-2" name="saveprofile">Save Changes</button>
                            </form>
                        </div>
                        <!-- CHANGE PICTURE -->
                        <div class="col s12 m12 l4 push-l4 scale-transition scale-out" id="profile-image">
                            <form action="../controller/save_profile_process.php" method="POST" enctype="multipart/form-data">

                                <blockquote style="border-left:5px solid #4fc3f7;"><b>Change Profile Picture</b></blockquote>
                                <div class="file-field input-field">
                                    <?php
                                         $result = $Diary->fetch_Owner($owner_id);
                                         if($row = mysqli_fetch_row($result))
                                         {
                                            if(empty($row[6]))
                                            echo "<img src='images/default_user_img.png' width='100px' height='100px' id='userimg' />";
                                            else
                                            echo "<img src='{$row[6]}' width='100px' height='100px' id='userimg' />";
                                         }
                                    ?>
                                    <br/>
                                    <div class="btn light-blue lighten-2">
                                        <span>Image</span>
                                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" multiple>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" placeholder="Profile Image" type="text">
                                    </div>
                                </div>
                                <button class="btn waves-effect waves-light light-blue lighten-2" name="saveimage">Save Changes</button>
                            </form>
                        </div>
                        <!-- CHANGE PASSWORD -->
                        <div class="col s12 m12 l4 push-l4 scale-transition scale-out" id="change-pass">
                            <form action="../controller/save_profile_process.php" method="POST">

                                <blockquote style="border-left:5px solid #4fc3f7;"><b>Change Password</b></blockquote>
                                <div class="input-field">
                                    <input id="oPassword" name="oPassword" type="password">
                                    <label for="oPassword">Current Password</label>
                                </div>
                                <div class="input-field">
                                    <input id="nPassword" name="nPassword" type="password">
                                    <label for="nPassword">New Password</label>
                                </div>
                                <div class="input-field">
                                    <input id="cnPassword" name="cnPassword" type="password">
                                    <label for="cnPassword">Confirm Password</label>
                                </div>
                                <button class="btn waves-effect waves-light light-blue lighten-2" name="savepass">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <?php include("includes/footer.php"); ?>
    </body>
</html>