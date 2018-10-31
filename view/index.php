<?php
    include("../model/MyDiary.php");
    date_default_timezone_set('Asia/Manila');
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: login.php");
        exit;
    }
    $owner_id = $_SESSION["owner_id"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home - Diary</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="materialize/fonts.googleapis.com/icon_family-material+Icons.css">
        <link rel="stylesheet" href="materialize/css/materialize.css">
        <link rel="stylesheet" href="materialize/css/custom.css">
        <link rel="icon" href="images/icon.ico">
    </head>
    <body class="blue-grey lighten-5">
        
        <div class="row z-depth-1 white">
            <div class="container">
                <div class="col s7 m6 l6">        
                    <ul>
                        <li><a class="act" href="index.php"><i class="material-icons waves-effect scale-transition">home</i><span class="menu">Home</span></a></li>
                        <li><a href="diary.php"><i class="material-icons waves-effect scale-transition">book</i><span class="menu">Diary</span></a></li>
                    </ul>
                </div>
                <div class="col s5 m6 l6 right">
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
                                        echo "<div id='clearB'>";
                                        echo $b['ttlnoti'];
                                        echo "</div>";
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
                                        <span class="title black-text"><?php echo $n['owner_firstname']." ".$n['owner_lastname']; ?></span>
                                        <p><i style="color:#4fc3f7" class="tiny material-icons">thumb_up</i> Likes your story - <?php echo $n['story_title']; ?></p>
                                        <p style="font-size:0.7em;">Date: <?php echo date("M j, Y g:i a", strtotime("{$n['time_unseen']}")); ?></p>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    echo "<div class='center'>Nothing</div>";
                                }
                                $seen = date("Y-m-d g:i");
                                $Diary->seen($owner_id,$seen);
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
                                echo "<img class='dropdown-trigger' data-target='picmenu' src='images/default_user_img.png' width='30px' height='30px' alt='my-profile-pic'>";
                                else
                                echo "<img class='dropdown-trigger' data-target='picmenu' src='{$row[6]}' width='30px' height='30px' alt='my-profile-pic'>";
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
                <?php include("includes/profile.php"); ?>
                <div class="col s12 m12 l9">
                    <div class="row">
                        <div class="col l1"></div>
                        <div class="col s12 m12 l11 z-depth-1 white scale-transition scale-out" id="public-content">
                            <div class="row">
                                <div class="col s12 l12">
                                    <h5>Public Diary's</h5>
                                    <?php
                                        $res = $Diary->public_feeds();
                                        
                                        if($res){
                                            foreach ($res as $r) {
                                            ?>
                                            <ul class="collection">
                                                <li class="collection-item avatar" style="width:100%">
                                                <?php
                                                    if(!empty($r["owner_img"]))
                                                    {
                                                        echo "<img src='{$r['owner_img']}' alt='profile-picture' class='circle'>";
                                                    } else 
                                                    {
                                                        echo "<img src='images/default_user_img.png' alt='profile-picture' class='circle'>";
                                                    }
                                                ?>
                                                <span class="title black-text"><?php if($r["owner_alias"]) echo $r["owner_alias"]; else echo "Unknown" ?> shared this story</span>
                                                <p>Title: <?php echo $r["story_title"]; ?></p>
                                                <p>Date: <?php echo date("M j, Y", strtotime("{$r['story_date']}")); ?> </p><br/>
                                                <p>Details: <br/><?php echo $r["story_content"]; ?></p>
                                                <a href="../controller/like_process.php?ownerid=<?php echo $owner_id;?>&storyid=<?php echo $r['story_id'];?>" class="unlikebtn secondary-content" style="margin:0 5px 0 0;">
                                                <i class="material-icons">thumb_up</i>
                                                </a>
                                                <?php $like = $Diary->liked($owner_id,$r['story_id']);
                                                    if($like){
                                                        foreach ($like as $l) {
                                                        ?>
                                                            <a href="../controller/like_process.php?ownerid=<?php echo $owner_id;?>&storyid=<?php echo $r['story_id'];?>" class="likedbtn secondary-content" style="margin:0 5px 0 0;">
                                                            <i class="material-icons">thumb_up</i>
                                                            </a>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                                <p style="margin:8px 0 0 0;" class="secondary-content black-text"><?php if($r["ttl_like"] == 0 ){ echo ""; } else { echo $r["ttl_like"];} ?></p>
                                                </li>
                                            </ul>
                                            <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <p id="back-top">
                <a href="#top"><span class="btn waves-effect waves-light light-blue lighten-2">Back to Top</span></a>
            </p>
            
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
</html>