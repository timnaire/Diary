<?php
    include("../model/MYDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }
    
    $owner_id = $_SESSION["owner_id"];
    $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";

    $Diary->forget_Diary($diaryid,$owner_id);
    $Diary->forget_Story($diaryid,$owner_id);
    header("Location: ../view/diary.php");
    exit;
?>