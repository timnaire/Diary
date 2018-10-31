<?php
    $firstname = $lastname = $username ="";
    if(isset($_GET["firstname"]))
    {
        $firstname = $_GET["firstname"];
    }
    if(isset($_GET["lastname"]))
    {
        $lastname = $_GET["lastname"];
    }
    if(isset($_GET["username"]))
    {
        $username = $_GET["username"];
    }
    if(isset($_GET["register"]))
    {
        if($_GET["register"] == "successful")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Successfully</strong> registered!</div>";
        }
    }
    if(isset($_GET["fields"]))
    {
        if($_GET["fields"] == "required")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>All fields</strong> are required, Please try again.</div>";
        }
    }
    if(isset($_GET["user"]))
    {
        if($_GET["user"] == "exist")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Username</strong> already exist, Please try again.</div>";
        }
    }
    if(isset($_GET["password"]))
    {
        if($_GET["password"] == "incorrect")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Both password</strong> must be the same.</div>";
        }
        if($_GET["password"] == "tooshort")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Password should be atleast 8 characters</strong> Please try again.</div>";
        }
    }
    if(isset($_GET["account"]))
    {
        if($_GET["account"] == "not_exist")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a>The<strong> account </strong> you are trying to login does not exist.</div>";
        }
    }
    if(isset($_GET["credentials"]))
    {
        if($_GET["credentials"] == "required")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a>Please enter your username and password to login.</div>";
        }
    }
    if(isset($_GET["password"]))
    {
        if($_GET["password"] == "empty")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Password required</strong>, please try again.</div>";
        }
    }
    if(isset($_GET["profile"]))
    {
        if($_GET["profile"] == "updated")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Profile Updated</strong></div>";
        }
    }
    if(isset($_GET["newuser"]))
    {
        if($_GET["newuser"] == "exist")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Username</strong> already exist, Please try again.</div>";
        }
    }
    if(isset($_GET["password_change"]))
    {
        if($_GET["password_change"] == "success")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Password Updated</strong></div>";
        }
    }
    if(isset($_GET["confirm_password"]))
    {
        if($_GET["confirm_password"] == "failed")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>New Password didn't Match</strong>, Please try again.</div>";
        }
    }
    if(isset($_GET["current_password"]))
    {
        if($_GET["current_password"] == "incorrect")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Old Password </strong>is incorrect, Please try again.</div>";
        }
    }
    if(isset($_GET["password_fields"]))
    {
        if($_GET["password_fields"] == "empty")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>All Fields are required!</strong>, Please try again.</div>";
        }
    }
    if(isset($_GET["profile_fields"]))
    {
        if($_GET["profile_fields"] == "empty")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>All Fields are required!</strong>, Please try again.</div>";
        }
    }
    if(isset($_GET["diary"]))
    {
        if($_GET["diary"] == "added")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary added!</strong> New diary has been created</div>";
        }
        if($_GET["diary"] == "deleted")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary successfully deleted!</strong></div>";
        }
        if($_GET["diary"] == "one_per_day")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Unsuccessful Add</strong>, One diary per day only.</div>";
        }
    }

    if(isset($_GET["diary_label"]))
    {
        if($_GET["diary_label"] == "empty")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary label required</strong>, Please try again.</div>";
        }
        if($_GET["diary_label"] == "exist")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary label exist</strong>, Please try another.</div>";
        }
        if($_GET["diary_label"] == "updated")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary label updated</strong>.</div>";
        }
        if($_GET["diary_label"] == "must_be_less_50_char")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Diary label must be less than 50 character</strong>, Please try another.</div>";
        }
    }

    if(isset($_GET["story"]))
    {
        if($_GET["story"] == "added")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story added!</strong> New story has been created.</div>";
        }
        if($_GET["story"] == "no_selected")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Delete story unsuccessful</strong> Please select atleast one story to be deteled.</div>";
        }
    }

    if(isset($_GET["details"]))
    {
        if($_GET["details"] == "must_be_less_1000_char")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story details must be less than 1000 characters! </strong> Please select atleast one story to be deteled.</div>";
        }
    }

    if(isset($_GET["title"]))
    {
        if($_GET["title"] == "exist")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story title exist!</strong> Please try again with different title.</div>";
        }
        if($_GET["title"] == "must_be_less_50_char")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story title must be less than 50 characters! </strong> Please try again with different title.</div>";
        }
    }

    if(isset($_GET["update"]))
    {
        if($_GET["update"] == "success")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story has been updated!</strong>.</div>";
        }
    }
    if(isset($_GET["share"]))
    {
        if($_GET["share"] == "success")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>You story has been shared!</strong>.</div>";
        }
    }
    if(isset($_GET["selected_story"]))
    {
        if($_GET["selected_story"] == "deleted")
        {
            echo "<div class='alert center alert-success'><a href='#' class='close' aria-label='close'>&times;</a><strong>Story Deleted Successfully!</strong>.</div>";
        }
    }
    if(isset($_GET["date_range"]))
    {
        if($_GET["date_range"] == "invalid")
        {
            echo "<div class='alert center alert-danger'><a href='#' class='close' aria-label='close'>&times;</a><strong>Invalid date range!</strong> Please try again.</div>";
        }
    }
?>