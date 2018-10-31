<?php
    include("../model/MyDiary.php");
    if(!isset($_SESSION["owner_id"]))
    {
        header("Location: ../view/login.php");
        exit;
    }
    $diarylabel = $diarycreated = "";
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");
    $owner_id = $_SESSION["owner_id"];
    $exilabel = "";
    $status = 1;
    if(isset($_POST["savediary"]))
    {
        $diarylabel = $_POST["diarylabel"];
        $diarycreated = $_POST["diarycreated"];
        $exidate = $Diary->exidate_Diary($date,$owner_id);
        $sqllabel = $Diary->label_Diary($diarylabel,$owner_id);
        foreach ($sqllabel as $s) {
            $exilabel = $s["diary_label"];
        }
        if(!empty($diarylabel))
        {
            if(strlen($diarylabel) > 50){
                header("Location: ../view/diary.php?diary_label=must_be_less_50_char");
                exit;
            } else {
                if($exidate)
                {
                    header("Location: ../view/diary.php?diary=one_per_day");
                    exit;
                } else if($diarylabel == $exilabel){
                    header("Location: ../view/diary.php?diary_label=exist");
                    exit;
                } else {
                    if($Diary->add_Diary($owner_id,$diarylabel,$diarycreated,$status))
                    {
                        header("Location: ../view/diary.php?diary=added");
                        exit;
                    }
                }
            }
        } else {
            header("Location: ../view/diary.php?diary_label=empty");
            exit;
        }
    }
    $ulabel = $diaryid = "";
    if(isset($_POST["updatediary"]))
    {
        $ulabel = $_POST["ulabel"];
        $diaryid = $_POST["uid"];
        if($Diary->update_Diary($diaryid, $ulabel,$owner_id)){
            header("Location: ../view/diary.php?diary_label=updated");
            exit;
        }
    }

    if(isset($_POST["deletediary"]))
?>