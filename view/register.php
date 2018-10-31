<!DOCTYPE html>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
        <title> Register - Diary </title>
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
            <div class="col s12 m5 l3 fadein">
                <?php
                    include("includes/alert.php");
                ?>
                <form action="../controller/registration_process.php" method="POST">
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">face</i>
                            <input id="first_name" type="text" name="firstname" value="<?php echo $firstname; ?>" class="validate" />
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" type="text" name="lastname" value="<?php echo $lastname; ?>" class="validate" />
                            <label for="last_name">Last Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="username" type="text" name="username" value="<?php echo $username; ?>" class="validate" />
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input id="password" type="password" name="password" class="validate" />
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">vpn_key</i>
                            <input id="cpassword" type="password" name="cpassword" class="validate" />
                            <label for="cpassword">Confirm Password</label>
                        </div>
                    </div>
                    <button name="btnregister" class="waves-effect waves-light light-blue lighten-2 btn col s12">Register</button>
                    <div style="margin-top:70px;"><h6>Already have an account? <a href="login.php">Click here.</a></h6></div>
                </form>
            </div>
        
        </div>

        <?php include("includes/footer.php"); ?>
    </body>
</html>