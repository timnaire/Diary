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
        <title>Story - Diary</title>
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
                        <li><a class="act" href="diary.php"><i class="material-icons waves-effect scale-transition">book</i><span class="menu">Diary</span></a></li>
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
                                <div class="col s12">
                                    <blockquote style="border-left:5px solid #4fc3f7;"><h4 class="center blue-grey-text">Diary:
                                        <?php
                                        $dir = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";
                                        $diary = $Diary->view_Diary($dir);
                                        if($diary)
                                        {
                                            foreach ($diary as $d) {
                                                echo $d["diary_label"];
                                            }
                                        } else {
                                            echo "Empty diary";
                                        }
                                        ?>
                                    </h4></blockquote>
                                </div>
                                <form action="../controller/search_story_process.php" method="GET">
                                    <input type="hidden" name="status" value="<?php if(isset($_GET["status"])){echo $_GET["status"];} ?>">
                                    <input name="diaryid" value="<?php if(isset($_GET["diaryid"])) {echo $_GET["diaryid"];} ?>" type="hidden">
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
                                    <div class="input-field col s12 m3 l2" style="margin:22px 0 0 0;">
                                        <button name="btnsearch" class="btn waves-effect waves-light light-blue lighten-2 col s12">Search</button>
                                    </div>
                                </form>
                                
                                <form action="../controller/list_story_process.php?diaryid=<?php echo $dir; ?>&status=1" method="POST">
                                    <div class="input-field col s12 m4 l3">
                                        <input type="text" class="datepicker" value="<?php if(isset($_GET["from"])){echo date("M j, Y", strtotime("{$_GET['from']}"));}else{echo date("M j, Y", strtotime("{$date}"));}?>" name="from" id="from">
                                        <label for="from">From</label>
                                    </div>
                                    <div class="input-field col s12 m4 l3">
                                        <input type="text" class="datepicker" value="<?php if(isset($_GET["until"])){echo date("M j, Y", strtotime("{$_GET['until']}"));}else{echo date("M j, Y", strtotime("{$date}"));}?>" name="until" id="until">
                                        <label for="from">Until</label>
                                    </div>
                                    <button name="btnlist" style="position:relative;top:22px;left:25px;" class="btn waves-effect waves-light light-blue lighten-2 col s12 m2 l2">List</button>
                                </form>
                                <form action="../controller/delete_story.php?diaryid=<?php echo $dir; ?>&status=1" method="POST">
                                <button style="position:relative;top:22px;left:50px;" onclick="return confirm('Are you sure you want to delete the selected story? This cannot be undone.')" name="btndel" class="btn waves-effect waves-light light-blue lighten-2 col s12 m2 l2">Delete</button>
                                <div class="col s12"><?php include("includes/alert.php"); ?></div>
                                <div class='col s12 m12 l12 scale-transition' id="listdiary">
                                    <?php
                                        $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";
                                        $storyid = isset($_GET["storyid"]) ? $_GET["storyid"] : "";
                                        $res = $Diary->viewall_Story($diaryid,$owner_id);
                                        $search = isset($_SESSION["stories"]) ? $_SESSION["stories"] : "";
                                        if(!empty($storyid) && $storyid != "notfound")
                                        {
                                            if($search){
                                                foreach($search as $s)
                                                {
                                                ?>
                                                    <div class="col s12 m4 l6">
                                                        <div class="card grey white">
                                                            <div class="card-content black-text">
                                                                <span class="card-title"><?php echo $s["story_title"] ?></span>
                                                                <p><?php echo "Date: ".date("M j, Y", strtotime("{$s['story_date']}")); ?></p>
                                                                <p><?php echo "Privacy: "; if($s["story_privacy"] == 1) echo "Private"; else echo "Public"; ?></p>
                                                                <p>Total Like: <?php echo $s['ttl_like']; ?></p>
                                                                <br/>
                                                                <p>Details:<br/><?php echo $s["story_content"]?>.</p>
                                                                
                                                            </div>
                                                            <div class="card-action">
                                                            <?php
                                                                if(isset($_GET["status"]))
                                                                {
                                                                    if($_GET["status"] == 1)
                                                                    {
                                                                        ?>
                                                                        <a href="#editstory" data-id="<?php echo $s["story_id"] ?>" data-priv="<?php echo $s["story_privacy"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-title="<?php echo $s["story_title"] ?>" data-content="<?php echo $s["story_content"] ?>" class="editstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Edit Story">
                                                                            <i class="material-icons">create</i>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                                <a href="#viewstory" data-title="<?php echo $s["story_title"] ?>" data-like="<?php echo $s["ttl_like"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-content="<?php echo $s["story_content"] ?>" class="viewstory modal-trigger waves-effect light-blue-text lighten-2" class="viewstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="View Story">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </a>
                                                                <label style="float:right" class='tobedel' data-position="left" data-tooltip="Check story to Delete">
                                                                    <input type="checkbox" id="tobedel" value="<?php echo $s["story_id"]; ?>" name="tobeDel[]" />
                                                                    <span><i class="material-icons" style="color:#4fc3f7">delete</i></span>
                                                                </label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>                                 
                                                <?php
                                                }
                                            }
                                            unset($_SESSION["stories"]);
                                        } else if($storyid == "notfound"){
                                            echo "<h5 class='center'>No records matching to your query</h5>";
                                        } else if(isset($_GET["from"]) && isset($_GET["until"])){
                                            $range = isset($_SESSION["listrange"]) ? $_SESSION["listrange"] : "";
                                            if($range)
                                            {
                                                foreach($range as $s) {
                                                ?>
                                                    <div class="col s12 m4 l6">
                                                        <div class="card grey white">
                                                            <div class="card-content black-text">
                                                                <span class="card-title"><?php echo $s["story_title"] ?></span>
                                                                <p><?php echo "Date: ".date("M j, Y", strtotime("{$s['story_date']}"));?></p>
                                                                <p><?php echo "Privacy: "; if($s["story_privacy"] == 1) echo "Private"; else echo "Public"; ?></p>
                                                                <p>Total Like: <?php echo $s['ttl_like']; ?></p>
                                                                <br/>
                                                                <p>Details:<br/><?php echo $s["story_content"]?>.</p>
                                                                
                                                            </div>
                                                            <div class="card-action">
                                                            <?php
                                                                if(isset($_GET["status"]))
                                                                {
                                                                    if($_GET["status"] == 1)
                                                                    {
                                                                        ?>
                                                                        <a href="#editstory" data-id="<?php echo $s["story_id"] ?>" data-priv="<?php echo $s["story_privacy"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-title="<?php echo $s["story_title"] ?>" data-content="<?php echo $s["story_content"] ?>" class="editstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Edit Story">
                                                                            <i class="material-icons">create</i>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                                <a href="#viewstory" data-title="<?php echo $s["story_title"] ?>" data-like="<?php echo $s["ttl_like"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-content="<?php echo $s["story_content"] ?>" class="viewstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="View Story">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </a>
                                                                <label style="float:right" class='tobedel' data-position="left" data-tooltip="Check story to Delete">
                                                                    <input type="checkbox" id="tobedel" value="<?php echo $s["story_id"]; ?>" name="tobeDel[]" />
                                                                    <span><i class="material-icons" style="color:#4fc3f7">delete</i></span>
                                                                </label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } 
                                            } else {
                                                echo "<h5 class='center'>No story's found</h5>";
                                            }
                                            unset($_SESSION["listrange"]);
                                        } else { 
                                            if($res) { 
                                                foreach ($res as $s) {
                                                ?>
                                                    <div class="col s12 m4 l6">
                                                        <div class="card grey white">
                                                            <div class="card-content black-text">
                                                                <span class="card-title"><?php echo $s["story_title"] ?></span>
                                                                <p><?php echo "Date: ".date("M j, Y", strtotime("{$s['story_date']}"));?></p>
                                                                <p><?php echo "Privacy: "; if($s["story_privacy"] == 1) echo "Private"; else echo "Public"; ?></p>
                                                                <p>Total Like: <?php echo $s['ttl_like']; ?></p>
                                                                <br/>
                                                                <p>Details:<br/><?php echo $s["story_content"]?>.</p>
                                                                
                                                            </div>
                                                            <div class="card-action">
                                                            <?php
                                                                if(isset($_GET["status"]))
                                                                {
                                                                    if($_GET["status"] == 1)
                                                                    {
                                                                        ?>
                                                                        <a href="#editstory" data-id="<?php echo $s["story_id"] ?>" data-priv="<?php echo $s["story_privacy"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-title="<?php echo $s["story_title"] ?>" data-content="<?php echo $s["story_content"] ?>" class="editstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="Edit Story">
                                                                            <i class="material-icons">create</i>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                                <a href="#viewstory" data-title="<?php echo $s["story_title"] ?>" data-like="<?php echo $s["ttl_like"] ?>" data-date="<?php echo date("M j, Y", strtotime("{$s['story_date']}")); ?>" data-content="<?php echo $s["story_content"] ?>" class="viewstory modal-trigger waves-effect light-blue-text lighten-2" data-position="left" data-tooltip="View Story">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </a>
                                                                <label style="float:right" class='tobedel' data-position="left" data-tooltip="Check story to Delete">
                                                                    <input type="checkbox" id="tobedel" value="<?php echo $s["story_id"]; ?>" name="tobeDel[]"  />
                                                                    <span><i class="material-icons" style="color:#4fc3f7">delete</i></span>
                                                                </label>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>                                
                                                <?php
                                                }
                                            } else {
                                                echo "<h5 class='center'>No story's found</h5>";
                                            }
                                        }
                                    ?>
                                </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="back-top">
            <a href="#top"><span class="btn waves-effect waves-light light-blue lighten-2">Back to Top</span></a>
        </p>

        <!-- View Diary -->
        <div id="viewstory" class="modal">
            <div class="modal-content">
                <h4 id="vtitle"></h4>
                <p id="vdate"></p>
                <p id="vlikes"></p>
                <br />
                Details:
                <p id="vcontent"></p>
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-blue btn-flat">Close</button>
            </div>
        </div>

        <!-- Edit Diary -->
        <div id="editstory" class="modal">
            <div class="modal-content">
                <h4>Edit Story</h4>
                <form action="../controller/story_process.php?status=1" method="POST">
                    <input name="diaryid" value="<?php if(isset($_GET["diaryid"])) {echo $_GET["diaryid"];} ?>" type="hidden">
                    <input id="storyid" name="storyid" type="hidden">
                    <div class="col s12">
                        <input id="ustorytitle" name="ustorytitle" type="text" value="" autofocus data-length="50">
                        <label for="ustorytitle">Story Title</label>
                    </div>
                    <div class="col s12">
                        <textarea name="ustorydetails" class="materialize-textarea" id="ustorydetails" cols="20" rows="10" data-length="1000"></textarea>
                        <label for="ustorydetails">Story details</label>
                    </div>
                    <div class="col s12">
                        <input id="date" type="text" class="datepicker" name="ustorycreated">
                        <label for="date">Story Date</label>
                    </div>
                    <select name="uprivacy" id="uprivacy">
                        <option value="1" selected>Private</option>
                        <option value="2">Public</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-blue btn-flat" name="updateStory">Update</button>
            </div>
                </form>
        </div>
        <!-- Add Story -->
        <div id="addstory" class="modal">
            <div class="modal-content">
                <h4>Create Story</h4>
                <form action="../controller/story_process.php?status=1" method="POST">
                    <input name="diaryid" value="<?php if(isset($_GET["diaryid"])) {echo $_GET["diaryid"];} ?>" type="hidden">
                    <div class="input-field col s12">
                        <input id="storytitle" name="storytitle" type="text" autofocus data-length="50">
                        <label for="storytitle">Story Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea name="storydetails" class="materialize-textarea" id="storydetails" cols="20" rows="10" data-length="1000"></textarea>
                        <label for="storydetails">Story details</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" class="datepicker" name="storycreated" value="<?php echo date("M j, Y", strtotime("{$date}")); ?>">
                    </div>
                    <select name="privacy" id="privacy">
                        <option value="1" selected >Private</option>
                        <option value="2">Public</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-blue btn-flat" name="savestory">Save</button>
            </div>
                </form>
        </div>
        <?php
            if(isset($_GET["status"]))
            {
                if($_GET["status"] == 1)
                {
                ?>
                <div class="fixed-action-btn scale-transition scale-out">
                    <a class="btn-floating btn-large add-tool modal-trigger light-blue lighten-2 pulse" href="#addstory" data-position="left" data-tooltip="Add Story">
                        <i class="large material-icons">mode_edit</i>
                    </a>
                </div>
                <?php
                }
            }
        ?>
        <?php include("includes/footer.php"); ?>
    </body>
</html>