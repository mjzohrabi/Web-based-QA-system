<?php
class PageModel{
    public static function get_user_info($email){
        $db=Db::getInstance();
        $record=$db->first("SELECT email FROM users WHERE email=:one",array(
            'one'=>$email
        ));
        return $record;
    }
    public static function get_user_info2($id){
    $db=Db::getInstance();
    $record=$db->first("SELECT user_id FROM users WHERE user_name=:one",array(
        'one'=>$id
    ));
    return $record;
    }
    public static function get_user_name($id){
        $db=Db::getInstance();
        $record=$db->first("SELECT user_name FROM users WHERE user_id=:one",array(
            'one'=>$id
        ));
        return $record['user_name'];
    }
    public static function get_question_name($qid){
        $db=Db::getInstance();
        $res=$db->first("SELECT q_name FROM questions WHERE q_id=:one",array(
            'one'=>$qid
        ));
        return $res['q_name'];
    }
    public static function get_info_for_chat($name){
        $db=Db::getInstance();
        $record=$db->first("SELECT user_id,class FROM users WHERE user_name=:one",array(
            'one'=>$name
        ));
        return $record;
    }
    public static function get_all_users(){
        $db=Db::getInstance();
        $record=$db->query("SELECT user_id,user_name FROM users");
        return $record;
    }
    public static function get_user_info_all_by_email($email){
        $db=Db::getInstance();
        $record=$db->first("SELECT * FROM users WHERE email=:one",array(
            'one'=>$email
        ));
        return $record;
    }
    public static function get_user_info_all_by_user_id($id){
        $db=Db::getInstance();
        $record=$db->first("SELECT * FROM users WHERE user_id=:one",array(
            'one'=>$id
        ));
        return $record;
    }
    public static function register_user($name,$hashed,$mail,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO users (user_name,password,class,email,register_time) VALUES (:one,:two,:three,:four,:five)",array(
            'one'=>$name,
            'two'=>$hashed,
            'three'=>'user',
            'four'=>$mail,
            'five'=>$date
        ));
    }
    public static function submit_question($name,$body,$date,$tags,$uid){
        $parts=explode(',',$tags);
        //echo count($parts);exit;
        if(count($parts)==1){
            $count=count($parts);
            for($i=$count;$i<5;$i++){
                $parts[$i]='';
            }
            //print_r($parts);exit;
            $db=Db::getInstance();
            $db->insert("INSERT INTO questions (q_name,q_body,asker,q_date,tag1,tag2,tag3,tag4,tag5) VALUES (:one,:two,:three,:four,:five,:six,:seven,:eight,:nine)",array(
                'one'=>$name,
                'two'=>$body,
                'three'=>$uid,
                'four'=>$date,
                'five'=>$parts[0],
                'six'=>$parts[1],
                'seven'=>$parts[2],
                'eight'=>$parts[3],
                'nine'=>$parts[4],
            ));
            return 1;
        }
        if (strpos($tags, ',') !== false&&count($parts)>1) {
            if(count($parts)>5){
                for($i=0;$i<5;$i++){
                    if(ctype_space($parts[$i])){
                        $parts[$i]='';
                    }
                }
                $db=Db::getInstance();
                $db->insert("INSERT INTO questions (q_name,q_body,asker,q_date,tag1,tag2,tag3,tag4,tag5) VALUES (:one,:two,:three,:four,:five,:six,:seven,:eight,:nine)",array(
                    'one'=>$name,
                    'two'=>$body,
                    'three'=>$uid,
                    'four'=>$date,
                    'five'=>$parts[0],
                    'six'=>$parts[1],
                    'seven'=>$parts[2],
                    'eight'=>$parts[3],
                    'nine'=>$parts[4],
                ));
                return 1;
            }
            else{
                $count=count($parts);
                for($i=$count;$i<5;$i++){
                    $parts[$i]='';
                }
                for($i=0;$i<5;$i++){
                    if(ctype_space($parts[$i])){
                        $parts[$i]='';
                    }
                }
                //print_r($parts);exit;
                $db=Db::getInstance();
                $db->insert("INSERT INTO questions (q_name,q_body,asker,q_date,tag1,tag2,tag3,tag4,tag5) VALUES (:one,:two,:three,:four,:five,:six,:seven,:eight,:nine)",array(
                    'one'=>$name,
                    'two'=>$body,
                    'three'=>$uid,
                    'four'=>$date,
                    'five'=>$parts[0],
                    'six'=>$parts[1],
                    'seven'=>$parts[2],
                    'eight'=>$parts[3],
                    'nine'=>$parts[4],
                ));
                return 1;
            }
        }
        else {
            return 0;
        }
    }
    public static function get_questions($tab){
        if($tab=='interesting'){
            $db=Db::getInstance();
            $result=$db->query("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id ORDER BY views DESC LIMIT 30");
            return $result;
        }
        if($tab=='recent'){
            $db=Db::getInstance();
            $result=$db->query("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id ORDER BY q_id DESC LIMIT 30");
            return $result;
        }

    }
    public static function get_all_questions($start,$count){
        $db=Db::getInstance();
        $result=$db->query("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id ORDER BY q_id DESC LIMIT $start,$count ");
        return $result;
    }
    public static function get_tagged_number($tag){
        $db=Db::getInstance();
        $result=$db->query("SELECT COUNT(*) AS total FROM questions WHERE tag1=:one OR tag2=:one OR tag3=:one OR tag4=:one OR tag5=:one ",array(
            'one'=>$tag
        ));
        return $result[0]['total'];
    }
    public static function get_all_questions_num(){
        $db=Db::getInstance();
        $result=$db->query("SELECT COUNT(*) AS total FROM questions");
        return $result[0]['total'];
    }
    public static function get_tagged_questions($tag,$start,$count){
        $db=Db::getInstance();
        $result=$db->query("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id WHERE tag1=:one OR tag2=:one OR tag3=:one OR tag4=:one OR tag5=:one ORDER BY q_id DESC LIMIT $start,$count ",array(
            'one'=>$tag
        ));
        return $result;
    }
    public static function get_question_to_view($qid){
        $db=Db::getInstance();
        $db->modify("UPDATE questions SET views=views+1 WHERE q_id=:one",array(
            'one'=>$qid
        ));
        $result=$db->first("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id WHERE questions.q_id=:one",array(
            'one'=>$qid
        ));
        return $result;
    }
    public static function get_last_edited_for_edit_q($qid){
        $db=Db::getInstance();
        $record=$db->first("SELECT q_body FROM edited_q WHERE q_id=:one ORDER BY e_id DESC",array(
            'one'=>$qid
        ));
        return $record;
    }
    public static function get_last_edited_for_edit_a($aid){
        $db=Db::getInstance();
        $record=$db->first("SELECT a_id,a_body FROM edited_a WHERE a_id=:one ORDER BY e_id DESC",array(
            'one'=>$aid
        ));
        return $record;
    }
    public static function get_a_body_for_edit_a($aid){
        $db=Db::getInstance();
        $record=$db->first("SELECT a_id,a_body FROM answers WHERE a_id=:one",array(
            'one'=>$aid
        ));
        return $record;
    }
    public static function get_q_body_for_edit_q($qid){
        $db=Db::getInstance();
        $record=$db->first("SELECT q_body FROM questions WHERE q_id=:one",array(
            'one'=>$qid
        ));
        return $record;
    }
    public static function get_answers_for_question($qid){
        $db=Db::getInstance();
        $result=$db->query("SELECT answers.*,users.user_name,users.class,users.reputation FROM answers LEFT OUTER JOIN users ON answers.replier=users.user_id WHERE answers.q_id=:one ORDER BY a_id DESC",array(
            'one'=>$qid
        ));
        return $result;
    }
    public static function submit_answer($qid,$body,$uid,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO answers (q_id,a_body,replier,a_date) VALUES (:one,:two,:three,:four)",array(
            'one'=>$qid,
            'two'=>$body,
            'three'=>$uid,
            'four'=>$date
        ));
        $toadd=$uid.',';
        $qq=$qid.',';
        $db->modify("UPDATE questions SET repliers=CONCAT(repliers,'$toadd') WHERE q_id=$qid");
        $db->modify("UPDATE users SET answered_q=CONCAT(answered_q,'$qq') WHERE user_id=$uid");
        return 1;
    }
    public static function submit_edit_q($qid,$newbody,$uid,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO edited_q (q_id,q_body,e_date,editor_id) VALUES (:one,:two,:three,:four)",array(
            'one'=>$qid,
            'two'=>$newbody,
            'three'=>$date,
            'four'=>$uid
        ));
        return 1;
    }
    public static function submit_edit_a($aid,$newbody,$uid,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO edited_a (a_id,a_body,e_date,editor_id) VALUES (:one,:two,:three,:four)",array(
            'one'=>$aid,
            'two'=>$newbody,
            'three'=>$date,
            'four'=>$uid
        ));
        return 1;
    }
    public static function get_last_q_edition($qid){
        $db=Db::getInstance();
        $results=$db->first("SELECT edited_q.*,users.user_name,users.class,users.reputation FROM edited_q LEFT OUTER JOIN users ON edited_q.editor_id=users.user_id WHERE q_id=:one ORDER BY e_id DESC LIMIT 1",array(
            'one'=>$qid
        ));
        return $results;
    }
    public static function get_last_a_edition($aid){
        $db=Db::getInstance();
        $results=$db->first("SELECT edited_a.*,users.user_name,users.class,users.reputation FROM edited_a LEFT OUTER JOIN users ON edited_a.editor_id=users.user_id WHERE a_id=:one ORDER BY e_id DESC LIMIT 1",array(
            'one'=>$aid
        ));
        return $results;
    }
    public static function get_edited_n_original_q($main){
        $db=Db::getInstance();
        $res[0]=$db->first("SELECT questions.asker,questions.q_body,questions.q_date,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id WHERE q_id=:one",array(
            'one'=>$main
        ));
        $res[1]=$db->query("SELECT edited_q.editor_id,edited_q.q_body,edited_q.e_date,users.user_name,users.class,users.reputation FROM edited_q LEFT OUTER JOIN users ON edited_q.editor_id=users.user_id WHERE q_id=:one ORDER BY e_id DESC ",array(
            'one'=>$main
        ));
        return $res;
    }
    public static function get_edited_n_original_a($main){
        $db=Db::getInstance();
        $res[0]=$db->first("SELECT answers.replier,answers.a_body,answers.a_date,users.user_name,users.class,users.reputation FROM answers LEFT OUTER JOIN users ON answers.replier=users.user_id WHERE a_id=:one",array(
            'one'=>$main
        ));
        $res[1]=$db->query("SELECT edited_a.editor_id,edited_a.a_body,edited_a.e_date,users.user_name,users.class,users.reputation FROM edited_a LEFT OUTER JOIN users ON edited_a.editor_id=users.user_id WHERE a_id=:one ORDER BY e_id DESC ",array(
            'one'=>$main
        ));
        return $res;
    }
    public static function vote_q($method,$uid,$id,$owner,$q){
        $db=Db::getInstance();
        $voters=$db->first("SELECT voters FROM questions WHERE q_id=:one",array(
            'one'=>$id
        ));
        $flag=1;
        $parts=explode(',',$voters['voters']);
        for($i=0;$i<count($parts);$i++){
            if($uid==$parts[$i]){
                $flag=0;
                break;
            }
        }
        if(!$flag){
            return 0;
        }
        else {
            if($method=='u'){
                $db->modify("UPDATE questions SET rate=rate+1,voters=CONCAT(voters,'$uid',',') WHERE q_id=:one",array(
                    'one'=>$id
                ));
                $db->modify("UPDATE users SET reputation=reputation+10,
                notification=CONCAT(notification,'$uid','/','$q','/','1',','),
                notf_num=notf_num+1
                WHERE user_id=:one",array(
                    'one'=>$owner
                ));
                return 1;
            }
            if($method=='d'){
                $db->modify("UPDATE questions SET rate=rate-1,voters=CONCAT(voters,'$uid',',') WHERE q_id=:one",array(
                    'one'=>$id
                ));
                $db->modify("UPDATE users SET reputation=reputation-2 ,
                notification=CONCAT(notification,'$uid','/','$q','/','0',','),
                notf_num=notf_num+1
                WHERE user_id=:one",array(
                    'one'=>$owner
                ));
                return 1;
            }
            else {
                return 00;
            }
        }
    }

    public static function vote_a($method,$uid,$id,$owner,$q){
        $db=Db::getInstance();
        $voters=$db->first("SELECT voters FROM answers WHERE a_id=:one",array(
            'one'=>$id
        ));
        $flag=1;
        $parts=explode(',',$voters['voters']);
        for($i=0;$i<count($parts);$i++){
            if($uid==$parts[$i]){
                $flag=0;
                break;
            }
        }
        if(!$flag){
            return '0';
        }
        else {
            if($method=='u'){
                $db->modify("UPDATE answers SET rate=rate+1,voters=CONCAT(voters,'$uid',',') WHERE a_id=:one",array(
                    'one'=>$id
                ));
                $db->modify("UPDATE users SET reputation=reputation+10 ,
                notification=CONCAT(notification,'$uid','/','$q','/','1',','),
                notf_num=notf_num+1
                WHERE user_id=:one",array(
                    'one'=>$owner
                ));
                return '1';
            }
            if($method=='d'){
                $db->modify("UPDATE answers SET rate=rate-1,voters=CONCAT(voters,'$uid',',') WHERE a_id=:one",array(
                    'one'=>$id
                ));
                $db->modify("UPDATE users SET reputation=reputation-2 ,
                notification=CONCAT(notification,'$uid','/','$q','/','0',','),
                notf_num=notf_num+1
                WHERE user_id=:one",array(
                    'one'=>$owner
                ));
                return '1';
            }
        }
    }
    public static function submit_comment_q($uid,$id,$body,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO comments_q (q_id,cmntr,c_body,c_date) VALUES (:one,:two,:three,:four)",array(
            'one'=>$id,
            'two'=>$uid,
            'three'=>$body,
            'four'=>$date
        ));
        $cid=$db->first("SELECT c_id from comments_q WHERE q_id=:one AND cmntr=:two AND c_body=:three AND c_date=:four",array(
            'one'=>$id,
            'two'=>$uid,
            'three'=>$body,
            'four'=>$date
        ));
        return $cid['c_id'];
    }
    public static function submit_comment_a($uid,$id,$body,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO comments_a (a_id,cmntr,c_body,c_date) VALUES (:one,:two,:three,:four) ",array(
            'one'=>$id,
            'two'=>$uid,
            'three'=>$body,
            'four'=>$date
        ));
        $cid=$db->first("SELECT c_id from comments_a WHERE a_id=:one AND cmntr=:two AND c_body=:three AND c_date=:four",array(
            'one'=>$id,
            'two'=>$uid,
            'three'=>$body,
            'four'=>$date
        ));
        return $cid['c_id'];
    }

    public static function get_comments_for_q($qid){
        $db=Db::getInstance();
        $results=$db->query("SELECT comments_q.*,users.user_name,users.class,users.reputation FROM comments_q LEFT OUTER JOIN users ON comments_q.cmntr=users.user_id WHERE comments_q.q_id=:one",array(
            'one'=>$qid
        ));
        return $results;
    }
    public static function get_comments_for_a($aid){
        $db=Db::getInstance();
        $results=$db->query("SELECT comments_a.*,users.user_name,users.class,users.reputation FROM comments_a LEFT OUTER JOIN users ON comments_a.cmntr=users.user_id WHERE comments_a.a_id=:one",array(
            'one'=>$aid
        ));
        return $results;
    }
    public static function set_correct_answer($uid,$qid,$aid){
        $db=Db::getInstance();
        $db->modify("UPDATE questions SET correct_answer=:one WHERE q_id=:two AND asker=:three",array(
            'one'=>$aid,
            'two'=>$qid,
            'three'=>$uid
        ));
        return 1;
    }
    public static function remove_correct_answer($uid,$qid){
        $db=Db::getInstance();
        $db->modify("UPDATE questions SET correct_answer='' WHERE q_id=:one AND asker=:two",array(
            'one'=>$qid,
            'two'=>$uid
        ));
        return 1;
    }
    public static function check_if_edited_q($qid){
        $db=Db::getInstance();
        $res=$db->first("SELECT edited_q.editor_id,edited_q.e_date,users.user_name,users.class,users.reputation FROM edited_q LEFT OUTER JOIN users ON edited_q.editor_id=users.user_id WHERE q_id=:one ORDER BY e_id DESC LIMIT 1",array(
            'one'=>$qid
        ));
        return $res;
    }
    public static function check_if_edited_a($qid){
        $db=Db::getInstance();
        $res=$db->first("SELECT edited_a.editor_id,edited_a.e_date,users.user_name,users.class,users.reputation FROM edited_a LEFT OUTER JOIN users ON edited_a.editor_id=users.user_id WHERE a_id=:one ORDER BY e_id DESC LIMIT 1",array(
            'one'=>$qid
        ));
        return $res;
    }
    public static function remove_comment_q($uid,$id){
        $db=Db::getInstance();
        $db->modify("DELETE FROM comments_q WHERE cmntr=:one AND c_id=:two",array(
            'one'=>$uid,
            'two'=>$id
        ));
        return 1;
    }
    public static function remove_comment_a($uid,$id){
        $db=Db::getInstance();
        $db->modify("DELETE FROM comments_a WHERE cmntr=:one AND c_id=:two",array(
            'one'=>$uid,
            'two'=>$id
        ));
        return 1;
    }
    public static function profile_views($uid){
        $db=Db::getInstance();
        $db->modify("UPDATE users  SET views=views+1 WHERE user_id=:one",array(
            'one'=>$uid
        ));
    }
    public static function get_rate($uid){
        $db=Db::getInstance();
        $rate=$db->first("SELECT rate FROM users WHERE user_id=:one",array(
            'one'=>$uid
        ));
        return $rate['rate'];
    }
    public static function rate_user($rated,$rater,$rate){
        $db=Db::getInstance();
        $check=$db->first("SELECT raters_id FROM users WHERE user_id=:one",array(
            'one'=>$rated
        ));
        $parts=explode(',',$check['raters_id']);
        for($i=0;$i<count($parts);$i++){
            if($parts[$i]==$rater){
                return 'n';
            }
        }
        $count=count($parts);
        $db->modify("UPDATE users SET rate=((rate*(:two-1))+:one)/:two WHERE user_id=:three",array(
            'one'=>$rate,
            'two'=>$count,
            'three'=>$rated
        ));
        $db->modify("UPDATE users SET raters_id=CONCAT(raters_id,'$rater',',') WHERE user_id=:one",array(
            'one'=>$rated
        ));
        return 'y';
    }
    public static function get_user_question($uid){
        $db=Db::getInstance();
        $records=$db->query("SELECT * FROM questions WHERE asker=:one",array(
            'one'=>$uid
        ));
        return $records;
    }

    public static function get_question_for_profile($qid){
        $db=Db::getInstance();
        $res=$db->first("SELECT * FROM questions WHERE q_id=:one",array(
            'one'=>$qid
        ));
        return $res;
    }
    public static function set_user_about($about,$uid){
        $db=Db::getInstance();
        $db->modify("UPDATE users SET about=:one WHERE user_id=:two",array(
            'one'=>$about,
            'two'=>$uid
        ));
        return 1;
    }
    public static function get_user_notification($uid){
        $db=Db::getInstance();
        $res=$db->first("SELECT notification,notf_num FROM users WHERE user_id=:one",array(
            'one'=>$uid
        ));
        return $res;
    }
    public static function clear_notification($uid){
        $db=Db::getInstance();
        $db->modify("UPDATE users SET notf_num=0 WHERE user_id=:one",array(
            'one'=>$uid
        ));
        return 1;
    }
    public static function add_new_fav_tag_for_user($tag,$uid){
        $db=Db::getInstance();
        $res=$db->first("SELECT fav_tags FROM users WHERE user_id=:one",array(
            'one'=>$uid
        ));
        $parts=explode(',',$res['fav_tags']);
        for($i=0;$i<count($parts);$i++){
            if($tag==$parts[$i]){
                return 0;
            }
        }
        $db->modify("UPDATE users SET fav_tags=CONCAT(fav_tags,'$tag',',') WHERE user_id=:one",array(
            'one'=>$uid
        ));
        return 1;
    }
    public static function remove_fav_tag_for_user($uid,$tag){
        $db=Db::getInstance();
        $res=$db->first("SELECT fav_tags FROM users WHERE user_id=:one",array(
            'one'=>$uid
        ));
        $parts=explode(',',$res['fav_tags']);
        //print_r($parts);
        $new='';
        for($i=0;$i<count($parts)-1;$i++){
            if($tag!=$parts[$i]){
                $new=$new.$parts[$i].',';
            }
        }
        //echo $new;exit;
        $db->modify("UPDATE users SET fav_tags=:one WHERE user_id=:two",array(
            'one'=>$new,
            'two'=>$uid
        ));
        return 1;
    }
    public static function get__user_questions_count($uid){
        $db=Db::getInstance();
        $res=$db->first("SELECT COUNT(q_id) AS num FROM questions WHERE asker=:one",array(
            'one'=>$uid
        ));
        return $res['num'];
    }
    public static function search($key){
        $db=Db::getInstance();
        $res[0]=$db->query("SELECT user_id,user_name,register_time,about,fav_tags,reputation FROM users WHERE user_name LIKE '%$key%'");
        $res[1]=$db->query("SELECT questions.*,users.user_name,users.class,users.reputation FROM questions LEFT OUTER JOIN users ON questions.asker=users.user_id WHERE q_name LIKE '%$key%' ORDER BY q_id DESC");
        return $res;
    }
    public static function get_last_answer_date($qid){
        $db=Db::getInstance();
        $res=$db->first("SELECT answers.a_date,answers.replier,users.user_name,users.class,users.reputation FROM answers LEFT OUTER JOIN users ON answers.replier=users.user_id WHERE q_id=:one ORDER BY a_id DESC LIMIT 1",array(
            'one'=>$qid
        ));
        return $res;
    }
    public static function get_all_users_2(){
        $db=Db::getInstance();
        $res=$db->query("SELECT user_id,user_name,register_time,about,fav_tags,reputation FROM users");
        return $res;
    }
    public static function get_chats(){
        $db=Db::getInstance();
        $res=$db->query("SELECT chat.ch_id,chat.ch_userid,chat.ch_body,chat.ch_date,users.user_name,users.class,users.access FROM chat LEFT OUTER JOIN users ON chat.ch_userid=users.user_id ORDER BY chat.ch_id DESC");
        return $res;
    }
    public static function set_chat($uid,$body,$main,$date){
        $db=Db::getInstance();
        $db->insert("INSERT INTO chat (ch_userid,ch_body,ch_main,ch_date) VALUES (:one,:two,:three,:four) ",array(
            'one'=>$uid,
            'two'=>$body,
            'three'=>$main,
            'four'=>$date
        ));
        return 1;
    }
    public static function get_chat_for_edit($cid){
        $db=Db::getInstance();
        $res=$db->first("SELECT ch_userid,ch_main FROM chat WHERE ch_id=:one",array(
            'one'=>$cid
        ));
        return $res;
    }
    public static function submit_chat_edit($cid,$body,$main,$uid){
        $db=Db::getInstance();
        $db->modify("UPDATE chat SET ch_body=:one,ch_main=:two WHERE ch_id=:three AND ch_userid=:four",array(
            'one'=>$body,
            'two'=>$main,
            'three'=>$cid,
            'four'=>$uid
        ));
        return 1;
    }
    public static function remove_chat_administrator($cid){
        $db=Db::getInstance();
        $db->modify("DELETE FROM chat WHERE ch_id=:one",array(
            'one'=>$cid
        ));
        return 1;
    }
    public static function remove_chat($cid,$uid){
        $db=Db::getInstance();
        $db->modify("DELETE FROM chat WHERE ch_id=:one AND ch_userid=:two",array(
            'one'=>$cid,
            'two'=>$uid
        ));
        return 1;
    }
    public static function get_info_for_administration(){
        $db=Db::getInstance();
        $results=$db->query("SELECT user_id,user_name,class,access,register_time FROM users");
        return $results;
    }
}
?>