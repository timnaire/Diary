<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }
    date_default_timezone_set('Asia/Manila');
    $ownerid = $_SESSION["owner_id"];
    $diaryid = $storyid = $title = $details = $privacy = $date = $exititle = "";
    $status = isset($_GET["status"]) ? $_GET["status"] : "";
    if(isset($_POST["savestory"]))
    {
        $title = $_POST["storytitle"];
        $details = $_POST["storydetails"];
        $date = $_POST["storycreated"];
        $privacy = $_POST["privacy"];
        $time = strtotime($date);
        $newdate = date("Y-m-d",$time);
        $diaryid = $_POST["diaryid"];
        $exist = $Diary->title_Story($diaryid,$title,$ownerid);
        if(!empty($title) && !empty($details) && !empty($newdate)){
            if(strlen($title) > 50)
            {
                header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&title=must_be_less_50_char");
                exit;
            } else if(strlen($details) > 1000){
                header("Location: Location: ../view/story.php?diaryid={$diaryid}&status={$status}&details=must_be_less_1000_char");
                exit;
            } else {
                if($exist)
                {
                    header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&title=exist");
                    exit;
                } else {
                    $Diary->add_Story($diaryid,$newdate,$ownerid,$title,$details,$privacy);
                    header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&story=added");
                    exit;
                }
            }
        } else {
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&fields=required");
            exit;
        }
       
    }

    if(isset($_POST["updateStory"]))
    {
        $title = $_POST["ustorytitle"];
        $details = $_POST["ustorydetails"];
        $date = $_POST["ustorycreated"];
        $time = strtotime($date);
        $newdate = date("Y-m-d",$time);
        $uprivacy = $_POST["uprivacy"];
        $diaryid = $_POST["diaryid"];
        $storyid = $_POST["storyid"];
        $exist = $Diary->ctitle_Story($diaryid,$title,$storyid,$ownerid);
        if($exist)
        {
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&title=exist");
            exit;
        }else{
            $Diary->update_Story($storyid,$newdate,$title,$details,$uprivacy);
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&update=success");
            exit;
        }
    }
    
?>