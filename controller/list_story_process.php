<?php
    include("../model/MyDiary.php");
    date_default_timezone_set('Asia/Manila');
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }

    $diaryid = isset($_GET["diaryid"]) ? $_GET["diaryid"] : "";
    $status = isset($_GET["status"]) ? $_GET["status"] : "";
    $from = isset($_POST["from"]) ? $_POST["from"] : "";
    $until = isset($_POST["until"]) ? $_POST["until"] : "";

    if(isset($_POST["btnlist"]))
    {
        $tfrom = strtotime($from);
        $newfrom = date("Y-m-d",$tfrom);
        $tuntil = strtotime($until);
        $newuntil = date("Y-m-d",$tuntil);
        
        if($tfrom <= $tuntil)
        {
            if($_SESSION["listrange"] = $Diary->list_Story($diaryid,$newfrom,$newuntil))
            {
                echo "im in";
                header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&from={$newfrom}&until={$newuntil}");
                exit;
            } else {
                header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&from={$newfrom}&until={$newuntil}");
                exit;
            }
        } else if($tfrom > $tuntil){
            echo "haha";
            header("Location: ../view/story.php?diaryid={$diaryid}&status={$status}&from={$newfrom}&until={$newuntil}&date_range=invalid");
            exit;
        }
    }

?>