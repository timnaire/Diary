<?php
    include("../model/MyDiary.php");
    session_destroy();
    unset($Diary);
    header("Location: ../view/login.php");
    exit;
?>