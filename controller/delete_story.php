<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }
   
    $tobedel = isset($_POST["tobeDel"]) ? $_POST["tobeDel"] : "";
    $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";
    $status = isset($_GET["status"]) ? $_GET["status"] : "";

    if(isset($_POST["btndel"]))
    {
        if($tobedel)
        {
            foreach ($tobedel as $del) {
                $Diary->delete_Story($del);
            }
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&selected_story=deleted");
            exit;
        } else {
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&story=no_selected");
            exit;
        }
    }
?>