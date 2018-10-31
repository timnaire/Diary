<?php
    session_start();
    if(isset($_SESSION["owner_id"]))
    {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
        <title> Login - Diary </title>
        <link href="materialize/fonts.googleapis.com/icon_family-Material+Icons.css" rel="stylesheet">
        <link rel="stylesheet" href="materialize/css/materialize.css">
        <link rel="stylesheet" href="materialize/css/custom.css">
        <link rel="icon" href="images/icon.ico">
    </head>
    <body>
        <div class="row light-blue lighten-2">
            <div class="col s12 m6 l4">
                <h1 class="title">My Diary</h1>
            </div>
        </div>
        <div class="row">
            
            <div class="col s12 l6 m5">
                <div class="fbody">
                    <i class="medium material-icons prefix">create</i>
                    <div class="fdesc">
                        <h5>
                            <strong>Create</strong> your own personalize diary.
                        </h5>
                    </div>
                    <i class="medium material-icons prefix">perm_contact_calendar</i>
                    <div class="fdesc">
                        <h5>
                            <strong>Share</strong> your diary to public.
                        </h5>
                    </div>
                    <i class="medium material-icons prefix">security</i>
                    <div class="fdesc">
                        <h5>
                            <strong>We secure</strong> your diary.
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col s12 m5 l3 fadein" id="login">
                <?php
                    include("includes/alert.php");
                ?>
                <form action="../controller/login_process.php" method="POST">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="username" type="text" name="username" value="<?php if(isset($_COOKIE["member_user"])){echo $_COOKIE["member_user"];} if(isset($_GET["username"]) && empty($_COOKIE["member_user"])){echo $username;} ?>" <?php if(isset($_GET["credentials"])){ echo "autofocus";}?> class="validate" />
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input id="password" type="password" name="password" value="<?php if(isset($_COOKIE["member_pass"])){echo $_COOKIE["member_pass"];} ?>" <?php if(isset($_GET["account"])){ echo "autofocus";}?> class="validate" />
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="rememberme" <?php if(isset($_COOKIE["member_user"])) { echo "checked";  } if(isset($_GET["remember"])){if($_GET["remember"]=="checked"){echo "checked";}} ?> />
                            <span>Remember me</span>
                        </label>
                    </p>
                    <button name="btnlogin" class="waves-effect waves-light light-blue lighten-2 btn col s12">Login</button>
                    <div style="margin-top:70px;"><h6>Need an account?<a href="register.php"> Register</a></h6></div>
                </form>
            </div>
        
        </div>

        <?php include("includes/footer.php"); ?>
    </body>
</html>