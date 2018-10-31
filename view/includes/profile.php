<div class="col s12 m12 l3 z-depth-1 white">
                    <div class="profile-container">
                        <div class="row">
                            <div class="col s4 m2 l4">
                                <div class="profile-pic">
                                    <?php
                                        $firstname = $lastname = $alias = $username = "";
                                        $result = $Diary->fetch_Owner($owner_id);
                                        if($row = mysqli_fetch_row($result))
                                        {

                                            $_SESSION["lastname"] = $lastname = $row[1];
                                            $_SESSION["firstname"] = $firstname = $row[2];
                                            $_SESSION["alias"] = $alias = $row[3];
                                            $_SESSION["username"] = $username = $row[4];
                                            if(empty($row[6]))
                                            {
                                                echo "<img src='images/default_user_img.png' width='75px' height='75px' />";
                                            } else {
                                                echo "<img src='{$row[6]}' width='75px' height='75px'>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col s8 m10 l8">
                                <div class="profile-name">
                                    <h6><?php echo $firstname." ".$lastname; if(!empty($alias)) echo ' ('.$alias.')'; else echo "";  ?></h6>
                                    <span class="username">@<?php echo $username;?></span>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr />
                        <div class="row">
                            <div class="col s4 m4 l4 c">
                                <span class="bdg">Shared</span>
                                <?php
                                    $result = $Diary->ttlshared_Owner($owner_id);
                                    if($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<p>".$row['ttlshared']."</p>";
                                    }
                                ?>
                            </div>
                            <div class="col s4 m4 l4 c">
                                <span class="bdg">Diary</span>
                                <?php
                                    $result = $Diary->ttldiary_Owner($owner_id);
                                    if($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<p>".$row["ttldiary"]."</p>";
                                    }
                                ?>
                            </div>
                            <div class="col s4 m4 l4 c">
                                <span class="bdg">Story</span>
                                <?php
                                    $result = $Diary->ttlstory_Owner($owner_id);
                                    if($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<p>".$row["ttlstory"]."</p>";
                                    }
                                ?>
                            </div>
                            <?php
                                if($_SERVER["PHP_SELF"] != "/Diary/view/diary.php"){
                                    ?>
                                <div class="col s12">
                                <a href="diary.php" class="btn waves-effect waves-light light-blue lighten-2 col s12">Create Diary Now</a>
                                </div>
                                    <?php
                                }
                            ?>
                        </div>

                        <blockquote style="border-left:5px solid #4fc3f7;"><h6>Active Recent Diary's</h6></blockquote>
                            <ul>
                                <?php
                                    $res = $Diary->arecent_Diary($owner_id);
                                    if($res)
                                    {
                                        foreach($res as $r)
                                        {
                                            echo "<div class='col s12'>";
                                            echo "Title: "."<a href='story.php?diaryid={$r['diary_id']}&status=1'>".$r["diary_label"]."</a>";
                                            echo "</div>";
                                        }
                                    }
                                ?>
                            </ul>
                        <blockquote style="border-left:5px solid #4fc3f7;"><h6>Forgotten Recent Diary's</h6></blockquote>
                            <ul>
                                <?php
                                    $res = $Diary->frecent_Diary($owner_id);
                                    if($res)
                                    {
                                        foreach($res as $r)
                                        {
                                            echo "<div class='col s12'>";
                                            echo "Title: "."<a href='story.php?diaryid={$r['diary_id']}&status=2'>".$r["diary_label"]."</a>";
                                            echo "</div>";
                                        }
                                    }
                                ?>
                                <div class="col s12"><br/></div>
                            </ul>
                    </div>
                </div>