<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }

    $owner_id = $_SESSION["owner_id"];
    $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";

    $Diary->del_Diary($diaryid,$owner_id);
    header("Location: ../view/diary.php?diary=deleted");
    exit;
?>