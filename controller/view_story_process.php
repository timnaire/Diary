<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }

    $ownerid = $_SESSION["owner_id"];
    $diaryid = $_GET["diary_id"];

    $res = $Diary->viewall_Story($diaryid,$ownerid);
    if($res)
    {
        foreach ($res as $r) {
            $_SESSION["storytitle"] = $r["story_title"];
            $_SESSION["story_content"] = $r["story_content"];
        }
        header("Location: ../view/story.php?diaryid=");
    } else {
        header("Location: ../view/story.php?diaryid={$diaryid}");
        exit;
    }

?>