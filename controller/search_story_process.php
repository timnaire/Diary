<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }
    
    $owner_id = $_SESSION["owner_id"];
    $diaryid = $_GET["diaryid"];
    $option = $searched = "";
    $storyid = array();
    $status = isset($_GET["status"]) ? $_GET["status"] : "" ;
    echo $status;
    if(isset($_GET["btnsearch"]))
    {
        $option = $_GET["searchOP"];
        $searched = $_GET["searched"];

        if(!empty($searched)){
            if($option == "title")
            {
                $res = $Diary->stitle_Story($owner_id,$diaryid,$searched);
                if($res){
                    foreach ($res as $r) {
                        $storyid[] = $r["story_id"]; 
                    }
                    $_SESSION["stories"] = $res;
                    header("Location: ../view/story.php?diaryid={$diaryid}&storyid={$storyid}&status={$status}&searched={$searched}&filter={$option}");
                    exit;
                } else {
                    header("Location: ../view/story.php?diaryid={$diaryid}&storyid=notfound&status={$status}&searched={$searched}&filter={$option}");
                    exit;
                }
            } else if($option == "content"){
                $res = $Diary->scontent_Story($owner_id,$diaryid,$searched);
                if($res)
                {
                    foreach ($res as $r) {
                        $storyid[] = $r["story_id"];
                    }
                    $_SESSION["stories"] = $res;
                    header("Location: ../view/story.php?diaryid={$diaryid}&storyid={$storyid}&status={$status}&searched={$searched}&filter={$option}");
                    exit;
                } else {
                    header("Location: ../view/story.php?diaryid={$diaryid}&storyid=notfound&status={$status}&searched={$searched}&filter={$option}");
                    exit;
                }
                
            }
        } else {
            header("Location: ../view/story.php?diaryid={$diaryid}&storyid=notfound&status={$status}&searched=&filter=title");
            exit;
        }
    }
?>