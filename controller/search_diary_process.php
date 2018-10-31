<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }

    $owner_id = $_SESSION["owner_id"];
    $option = $searched = "";
    $diaryid = array();
    if(isset($_GET["btnsearch"]))
    {
        $option = $_GET["searchOP"];
        $searched = $_GET["searched"];

        if(!empty($searched)){
            if($option == "title")
            {
                $res = $Diary->dtitle_Diary($searched,$owner_id);
                if($res){
                    foreach ($res as $r) {
                        $diaryid[] = $r["diary_id"]; 
                    }
                    $_SESSION["diaries"] = $res;
                    header("Location: ../view/diary.php?diaryid={$diaryid}&searched={$searched}&filter={$option}");
                    exit;
                } else {
                    header("Location: ../view/diary.php?diaryid=notfound&searched={$searched}&filter={$option}");
                    exit;
                }
            } else if($option == "content"){
                $res = $Diary->scontent_Diary($searched,$owner_id);
                if($res)
                {
                    foreach ($res as $r) {
                        $diaryid[] = $r["diary_id"]; 
                    }
                    $_SESSION["diaries"] = $res;
                    header("Location: ../view/diary.php?diaryid={$diaryid}&searched={$searched}&filter={$option}");
                    exit;
                } else {
                    header("Location: ../view/diary.php?diaryid=notfound&searched={$searched}&filter={$option}");
                    exit;
                }
                
            }
        } else {
            header("Location: ../view/diary.php?diaryid=notfound&searched=&filter=title");
            exit;
        }
    }
?>