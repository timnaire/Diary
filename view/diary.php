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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Diary</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="materialize/fonts.googleapis.com/icon_family-material+Icons.css">
        <link rel="stylesheet" href="materialize/css/materialize.css">
        <link rel="stylesheet" href="materialize/css/custom.css">
        <link rel="icon" href="images/icon.ico">
    </head>
    <body class="blue-grey lighten-5">
        
        <div class="row z-depth-1 white">
            <div class="container">
                <div class="col s7 m8 l6">        
                    <ul>
                        <li><a href="index.php"><i class="material-icons waves-effect scale-transition">home</i><span class="menu">Home</span></a></li>
                        <li><a class="act" href="diary.php"><i class="material-icons waves-effect scale-transition">book</i><span class="menu">Diary</span></a></li>
                    </ul>
                </div>
                <div class="col s5 m4 l6 right">
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
                        <div class="col s1 m1 l1"></div>
                        <div class="col s12 m12 l11 z-depth-1 white scale-transition scale-out" id="diary-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <blockquote style="border-left:5px solid #4fc3f7;"><h4 class="center blue-grey-text">My Diary</h4></blockquote>
                                </div>
                                <form action="../controller/search_diary_process.php" method="GET">
                                    <div class='input-field col s12 m6 l8'>
                                            <input id="searched" type="text" value="<?php if(isset($_GET["searched"])){echo $_GET["searched"]; } ?>" name="searched">
                                            <label for="searched">Search</label>
                                    </div>
                                    <div class="input-field col s12 m3 l2">
                                        <select name="searchOP">
                                            <?php
                                                if(isset($_GET["filter"]))
                                                {
                                                    if($_GET["filter"] == "title")
                                                    {
                                                        echo "<option value='title' selected>Title</option>";
                                                        echo "<option value='content'>Content</option>";
                                                    } else if($_GET["filter"] == "content"){
                                                        echo "<option value='title'>Title</option>";
                                                        echo "<option value='content' selected>Content</option>";
                                                    }
                                                } else {
                                                    echo "<option value='title' selected>Title</option>";
                                                    echo "<option value='content'>Content</option>";
                                                }
                                            ?>                                            
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m3 l2" style="margin:30px 0 0 0;">
                                        <button name="btnsearch" class="btn waves-effect waves-light light-blue lighten-2">Search</button>
                                    </div>
                                </form>
                                <div class="col s12"><?php include("includes/alert.php"); ?></div>
                                
                                <?php 
                                    if(empty($_SESSION["notice"])){
                                        ?>
                                        <div class="col s12">
                                            <div class='alert center alert-info'>
                                                <a href='#' class='close' aria-label='close'>&times;</a><strong>Notice:</strong> Only 1 diary per day.
                                            </div>
                                        </div>
                                        <?php
                                    }
                                $_SESSION["notice"] = "dontrepeat"; 
                                ?>
                                <div class='col s12 m12 l12 scale-transition' id="listdiary">
                                    <?php
                                        $alldiary = $Diary->viewall_Diary($owner_id);
                                        $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";
                                        $diaries = isset($_SESSION["diaries"]) ? $_SESSION["diaries"] : "";
                                        if(!empty($diaryid) && $diaryid != "notfound")
                                        {
                                            $diary = $Diary->view_Diary($diaryid);
                                            if($diaries)
                                            {
                                                foreach ($diaries as $d) {
                                                    if($d['story_content'] > 0){
                                                    ?>
                                                        <ul class="collection">
                                                            <li class="collection-item avatar" style="width:100%">
                                                                <i class="material-icons circle light-blue lighten-2">book</i>
                                                                <span class="title black-text"><?php echo $d["diary_label"]; ?></span>
                                                                <p>
                                                                    <?php echo "Date: ".date("M j, Y", strtotime("{$d['diary_datecreated']}")); ?>
                                                                </p>
                                                                <p>
                                                                    <?php echo "Status: "; if($d["diary_status"] == "2") { echo "Forgotten"; } else echo "Active"; ?>
                                                                </p>
                                                                <?php
                                                                if($d["diary_status"] == 1)
                                                                {
                                                                    ?>
                                                                    <a href="#editdiary" data-id="<?php echo $d['diary_id']; ?>" data-label="<?php echo $d['diary_label']; ?>" style="margin:0 150px 0 0;" class="editdiary secondary-content modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Edit Diary"><i class="material-icons"><i class="material-icons">create</i></a>
                                                                    <a href="#" data-diaryid="<?php echo $d['diary_id']; ?>" style="margin:0 50px 0 0;" class="forget secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Forget Diary"><i class="material-icons">remove_circle_outline</i></a>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <a href="../view/story.php?diaryid=<?php echo $d['diary_id'];?>&status=<?php echo $d['diary_status']?>" <?php if($d["diary_status"] == 1) echo "style='margin:0 100px 0 0;'"; else echo "style='margin:0 50px 0 0;'" ?> class="viewdiary secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="View Diary"><i class="material-icons">remove_red_eye</i></a>
                                                                <a href="#" data-diaryid="<?php echo $d['diary_id']; ?>" class="delete secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Delete Diary"><i class="material-icons">delete</i></a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    } 
                                                }
                                            }
                                            unset($_SESSION["diaries"]);
                                        } else if($diaryid == "notfound"){
                                            echo "<h5 class='center'>No records matching to your query.</h5>";
                                        } else {
                                            if($alldiary)
                                            {
                                                foreach ($alldiary as $diary) {
                                                    ?>
                                                        <ul class="collection">
                                                            <li class="collection-item avatar" style="width:100%">
                                                                <i class="material-icons circle light-blue lighten-2">book</i>
                                                                <span class="title black-text"><?php echo "Title: ".$diary["diary_label"]; ?></span>
                                                                <p>
                                                                    <?php echo "Date: ".date("M j, Y", strtotime("{$diary['diary_datecreated']}")); ?>
                                                                </p>
                                                                <p>
                                                                    <?php echo "Status: "; if($diary["diary_status"] == "2") { echo "Forgotten"; } else echo "Active"; ?>
                                                                </p>
                                                            
                                                            <?php
                                                                if($diary["diary_status"] == 1)
                                                                {
                                                                    ?>
                                                                    <a href="#editdiary" data-id="<?php echo $diary['diary_id']; ?>" data-label="<?php echo $diary['diary_label']; ?>" style="margin:0 150px 0 0;" class="editdiary secondary-content modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Edit Diary"><i class="material-icons">create</i></a>
                                                                    <a href="#" data-diaryid="<?php echo $diary['diary_id']; ?>" style="margin:0 50px 0 0;" class="forget secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Forget Diary"><i class="material-icons">remove_circle_outline</i></a>
                                                                    
                                                                    <?php
                                                                }
                                                            ?>
                                                            <a href="../view/story.php?diaryid=<?php echo $diary['diary_id'];?>&status=<?php echo $diary['diary_status']?>" <?php if($diary["diary_status"] == 1) echo "style='margin:0 100px 0 0;'"; else echo "style='margin:0 50px 0 0;'" ?> class="viewdiary secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="View Diary"><i class="material-icons">remove_red_eye</i></a>
                                                            <a href="#" data-diaryid="<?php echo $diary['diary_id']; ?>" class="delete secondary-content waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Delete Diary"><i class="material-icons">delete</i></a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                }
                                            } else {
                                                echo "<h5 class='center'>You have 0 diary.</h5>";
                                            }
                                        }
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="back-top">
            <a href="#top"><span class="btn waves-effect waves-light light-blue lighten-2">Back to Top</span></a>
        </p>
        <!-- Edit Diary -->
        <input type="hidden" name="idRemove" id="idRemove">
        <div id="editdiary" class="modal">
            <div class="modal-content">
                <h4>Edit Diary</h4>
                <form action="../controller/diary_processes.php" method="POST">
                    <div class="col s12">
                        <input id="ulabel" name="ulabel" value="" autofocus data-length="50">
                        <label for="ulabel">Diary Label</label>
                    </div>
                    <input type="hidden" id="uid" name="uid">
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-blue btn-flat" name="updatediary">Update</button>
            </div>
                </form>
        </div>
        <!-- Add Diary -->
        <div id="adddiary" class="modal">
            <div class="modal-content">
                <h4>Create Diary</h4>
                <form action="../controller/diary_processes.php" method="POST">
                    <div class="input-field col s12">
                        <input id="diarylabel" name="diarylabel" type="text" autofocus data-length="50">
                        <label for="diarylabel">Diary Label</label>
                    </div>
                    <input type="hidden" name="diarycreated" value="<?php echo $date; ?>">
                
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-blue btn-flat" name="savediary">Save</button>
            </div>
                </form>
        </div>
        <div class="fixed-action-btn scale-transition scale-out">
            <a class="btn-floating btn-large add-tool modal-trigger light-blue lighten-2 pulse" href="#adddiary" data-position="left" data-tooltip="Add Diary">
                <i class="large material-icons">mode_edit</i>
            </a>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
</html>