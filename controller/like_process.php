<?php
    include("../model/MyDiary.php");
    date_default_timezone_set('Asia/Manila');
    $ownerid = isset($_GET["ownerid"]) ? $_GET["ownerid"] : "";
    $storyid = isset($_GET["storyid"]) ? $_GET["storyid"] : "";

    $unseen = date("Y-m-d g:i");
    $newunseen = date("M j, Y g:i a", strtotime("$unseen"));


    if($Diary->notification($ownerid,$storyid,$unseen))
    {
        header("Location: ../view/index.php");
        exit;
    } 
?>