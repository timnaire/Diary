<?php
    class MyDiary{

        private $host = "localhost";
	    private $user = "root";
	    private $password = "";
	    private $database = "diary";
	    private $conn;

        function __construct(){
            $this->conn = $this->connectDB();
        }

        function __destruct(){
            $this->conn = $this->closeDB();
        }

        //Database controller functions
        function connectDB(){
            $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
            return $conn;
        }

        function closeDB(){
            return mysqli_close($this->conn);
        }

        function runQuery($query){
            return mysqli_query($this->conn,$query);
        }
        
        function numRows($ownerid) {
            $sql = "SELECT * FROM diary WHERE owner_id = '$ownerid' ";
            $result  = $this->runQuery($sql);
            $rowcount = mysqli_num_rows($result);
            return $rowcount;	
        }

        function returnRow($sql){
            $result = $this->runQuery($sql);
            while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
            }       
            if(!empty($resultset))
                return $resultset;
        }

        // For All Owner table query functions

        function add_Owner($lastname,$firstname,$username,$password){
            $sql = "INSERT INTO owner (owner_lastname,owner_firstname,owner_username,owner_password) VALUES ('{$lastname}','{$firstname}','{$username}','{$password}')";
            return $this->runQuery($sql);
        }

        function exist_Owner($username,$encryptpass){
            $sql = "SELECT * FROM owner WHERE owner_username = '$username' AND owner_password = '$encryptpass'";
            return $this->runQuery($sql);
        }

        function user_Owner($username){
            $sql = "SELECT * FROM owner WHERE owner_username = '$username'";
            return $this->runQuery($sql);
        }

        function notuser_Owner($username,$id){
            $sql = "SELECT * FROM owner WHERE owner_username = '$username' AND owner_id != '$id' ";
            return $this->runQuery($sql);
        }

        function fetch_Owner($id){
            $sql = "SELECT * FROM owner WHERE owner_id = {$id}";
            return $this->runQuery($sql);
        }

        function ttldiary_Owner($id){
            $sql = "SELECT count(*) AS ttldiary FROM diary WHERE owner_id = {$id}";
            return $this->runQuery($sql);
        }

        function ttlstory_Owner($id){
            $sql = "SELECT count(*) AS ttlstory FROM story WHERE owner_id = {$id}";
            return $this->runQuery($sql);
        }

        function ttlshared_Owner($id){
            $sql = "SELECT count(*) AS ttlshared FROM story WHERE story_privacy = '2' AND owner_id = {$id}";
            return $this->runQuery($sql);
        }

        function update_Owner($firstname,$lastname,$alias,$username,$id){
            $sql = "UPDATE owner SET owner_firstname = '$firstname', owner_lastname = '$lastname' , owner_alias = '$alias' , owner_username = '$username' WHERE owner_id = '$id'  ";
            return $this->runQuery($sql);
        }

        function picture_Owner($path,$id){
            $sql = "UPDATE owner SET owner_img = '$path' WHERE owner_id = '$id'  ";
            return $this->runQuery($sql);
        }

        function selpass_Owner($id){
            $sql = "SELECT owner_password FROM owner WHERE owner_id = '$id' ";
            return $this->returnRow($sql);
        }

        function changepass_Owner($new,$id){
            $sql = "UPDATE owner SET owner_password = '$new' WHERE owner_id = '$id' ";
            return $this->runQuery($sql);
        }

        // For All Diary table query functions

        function viewall_Diary($ownerid){
            $sql = "SELECT * FROM diary WHERE owner_id = '$ownerid' ORDER BY diary_datecreated DESC";
            return $this->returnRow($sql);
        }
        
        function total_Diary($owner_id){
            $sql = "SELECT count(*) AS Total FROM diary WHERE owner_id = '$owner_id'";
            return $this->runQuery($sql);
        }

        function view_Diary($diary_id){
            $sql = "SELECT * FROM diary WHERE diary_id = '$diary_id' ";
            return $this->runQuery($sql);
        }

        function add_Diary($id,$label,$date,$status){
            $sql = "INSERT INTO diary (owner_id,diary_label, diary_datecreated,diary_status) VALUES ('{$id}','{$label}','{$date}','{$status}')";
            return $this->runQuery($sql);
        }

        function exidate_Diary($date,$id){
            $sql = "SELECT * FROM diary WHERE diary_datecreated = '$date' AND owner_id = '$id' ";
            return $this->returnRow($sql);
        }
        function label_Diary($label,$id){
            $sql = "SELECT * FROM diary WHERE diary_label = '$label' AND owner_id = '$id' ";
            return $this->returnRow($sql);
        }

        function dtitle_Diary($search,$id){
            $sql = "SELECT * FROM diary WHERE owner_id = '$id' AND diary_label LIKE '%$search%' ";
            return $this->returnRow($sql);
        }

        function scontent_Diary($search,$id){
            $sql = "SELECT d.*, (SELECT count(s.story_content) FROM story s WHERE d.diary_id = s.diary_id AND s.story_content LIKE '%$search%') AS story_content FROM diary d WHERE d.owner_id = '$id'  ";
            return $this->returnRow($sql);
        }

        function forget_Diary($diaryid,$id){
            $sql = "UPDATE diary SET diary_status = '2' WHERE owner_id = '$id' AND diary_id = '$diaryid' ";
            return $this->runQuery($sql);
        }

        function update_Diary($diaryid, $label, $id){
            $sql = "UPDATE diary SET diary_label = '$label' WHERE owner_id = '$id' AND diary_id = '$diaryid' ";
            return $this->runQuery($sql);
        }

        function arecent_Diary($id){
            $sql = "SELECT * FROM diary WHERE owner_id = '$id' AND diary_status = '1' ORDER BY diary_datecreated DESC LIMIT 5";
            return $this->returnRow($sql);
        }

        function frecent_Diary($id){
            $sql = "SELECT * FROM diary WHERE owner_id = '$id' AND diary_status = '2' ORDER BY diary_datecreated DESC LIMIT 5";
            return $this->returnRow($sql);
        }

        function del_Diary($diaryid,$id){
            $sql = "DELETE FROM diary WHERE diary_id = '$diaryid' AND owner_id = '$id' ";
            $this->runQuery($sql);
            $sql1 = "DELETE FROM story WHERE diary_id = '$diaryid' AND owner_id = '$id' ";
            return $this->runQuery($sql1);
        }

        // For All Story table query functions

        function viewall_Story($id,$owner_id){
            $sql = "SELECT s.*, (SELECT count(n.story_id) AS ttl_like FROM notification n WHERE n.story_id = s.story_id) AS ttl_like FROM story s WHERE s.diary_id = '$id' AND s.owner_id = '$owner_id' ORDER BY story_date DESC";
            return $this->returnRow($sql);
        }

        // function view_Story($storyid){
        //     $sql = "SELECT * FROM story WHERE story_id = '$storyid' ORDER BY story_date DESC";
        //     return $this->runQuery($sql);
        // }

        function title_Story($diaryid,$title,$id){
            $sql = "SELECT * FROM story WHERE diary_id = '$diaryid' AND story_title = '$title' AND owner_id = '$id' ";
            return $this->returnRow($sql);
        }
        function ctitle_Story($diaryid,$title,$storyid,$id){
            $sql = "SELECT * FROM story WHERE diary_id = '$diaryid' AND story_title = '$title' AND story_id != '$storyid' AND owner_id = '$id' ";
            return $this->returnRow($sql);
        }

        function add_Story($diaryid, $date, $id, $storytitle, $storydetails,$privacy){
            $sql = "INSERT INTO story (diary_id,story_date,owner_id,story_title,story_content,story_privacy) VALUES ('{$diaryid}','{$date}','{$id}','{$storytitle}','{$storydetails}','{$privacy}')";
            return $this->runQuery($sql);
            
        }

        function stitle_Story($id,$diaryid,$search){
            $sql = "SELECT s.*, (SELECT count(n.story_id) FROM notification n WHERE n.story_id = s.story_id) AS ttl_like FROM story s WHERE s.owner_id = '$id' AND s.diary_id = '$diaryid' AND s.story_title LIKE '%$search%' ORDER BY story_date DESC";
            return $this->returnRow($sql);
        }

        function scontent_Story($id,$diaryid,$search){
            $sql = "SELECT s.*, (SELECT count(n.story_id) FROM notification n WHERE n.story_id = s.story_id) as ttl_like FROM story s WHERE s.owner_id = '$id' AND s.diary_id = '$diaryid' AND s.story_content LIKE '%$search%' ORDER BY story_date DESC";
            return $this->returnRow($sql);
        }

        function update_Story($storyid,$date,$title,$details,$privacy){
            $sql = "UPDATE story SET story_date = '$date', story_title = '$title', story_content = '$details', story_privacy = '$privacy' WHERE story_id = '$storyid' ";
            return $this->runQuery($sql);
            
        }

        function list_Story($diaryid,$from,$until){
            $sql = "SELECT s.*, (SELECT count(n.story_id) FROM notification n WHERE n.story_id = s.story_id) as ttl_like FROM story s WHERE s.diary_id = '$diaryid' AND s.story_date BETWEEN '$from' AND '$until' ORDER BY story_date DESC";
            return $this->returnRow($sql);
        }

        function delete_Story($storyid){
            $sql = "DELETE FROM story WHERE story_id = '$storyid' ";
            return $this->runQuery($sql);
        }

        function forget_Story($diaryid,$ownerid){
            $sql = "UPDATE story SET story_privacy = '1' WHERE diary_id = '$diaryid' AND owner_id = '$ownerid' ";
            return $this->runQuery($sql);
        }
        
        //for public stories

        function public_feeds(){
            $sql = "SELECT s.*,o.owner_img,o.owner_alias, (SELECT count(n.story_id) FROM notification n WHERE n.story_id = s.story_id ) AS ttl_like FROM story s LEFT JOIN owner o on s.owner_id = o.owner_id WHERE s.story_privacy = '2' ORDER BY story_date DESC";
            return $this->returnRow($sql);
        }

        function liked($id,$storyid){
            $sql = "SELECT * FROM notification WHERE story_id = '$storyid' AND owner_id = '$id' ";
            return $this->returnRow($sql);
        }

        function notification($ownerid,$storyid,$unseen){
            $sql2 = "SELECT * FROM notification WHERE owner_id = '$ownerid' AND story_id = '$storyid' ";
            $res = $this->returnRow($sql2);
            if($res){
                foreach($res as $r){
                    if($r['owner_id'] == $ownerid){
                        $sql4 = "DELETE FROM notification WHERE owner_id = '$ownerid' AND story_id = '$storyid' ";
                        return $this->runQuery($sql4);
                    }
                }
            } else {
                $sql = "INSERT INTO notification(owner_id,story_id,time_unseen) VALUES('{$ownerid}','{$storyid}','{$unseen}')";
                return $this->runQuery($sql);
            }
        }

        function receive_Notification($ownerid){
            $sql = "SELECT n.*,s.*, o.owner_firstname,o.owner_lastname,o.owner_img FROM notification n, story s, owner o WHERE n.story_id = s.story_id AND n.owner_id != s.owner_id AND s.owner_id = '$ownerid' AND o.owner_id = n.owner_id ORDER BY time_unseen DESC limit 5";
            return $this->returnRow($sql);
        }

        function ttlnotification($ownerid){
            $sql = "SELECT count(*) as ttlnoti FROM notification n, story s, owner o WHERE n.story_id = s.story_id AND n.owner_id != s.owner_id AND s.owner_id = '$ownerid' AND o.owner_id != s.owner_id AND o.owner_id != n.owner_id AND n.time_seen is null";
            return $this->runQuery($sql);
        }

        function seen($ownerid,$seen){
            $sql = "UPDATE notification n SET time_seen = '$seen' WHERE (SELECT owner_id FROM story WHERE story_id = n.story_id) = '$ownerid' ";
            return $this->runQuery($sql);
        }

    }

    session_start();
    $Diary = new MyDiary();
    
?>