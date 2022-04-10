<?php
class UserController{
    public function __construct()
    {
    }
    public static function getmethods(){
        return get_class_methods("UserController");
    }
    public function login($url){
        if(isset($_SESSION['mail'])){
            echo 'You are already logged in';
            exit;
        }
        $mail=$_POST['email'];
        $pass=$_POST['password'];
        global $config;
        $hashed=md5($pass.$config['salt']);
        $record=PageModel::get_user_info_all_by_email($mail);
        if($record==null){
            View::purerender('/view/msgs/fail.php',array('one'=>'Login failed,please check your email or password!'));
        }
        if($mail==$record['email']){
            if($hashed==$record['password']){
                $_SESSION['mail']=$mail;
                $_SESSION['name']=$record['user_name'];
                $_SESSION['uid']=$record['user_id'];
                $_SESSION['class']=$record['class'];
                setcookie('uid',$record['user_id'],time() + (10 * 365 * 24 * 60 * 60),'/');
                setcookie('pass',$record['password'],time() + (10 * 365 * 24 * 60 * 60),'/');
                //echo $url;exit;
                if($url=='en'||$url=='fa'){
                    header("Location:/".$url);
                }
                else if ($url=='ask'){
                    header("Location:/"._main_lang."/questions/ask");
                }
                else if($url=='chat') {
                    header("Location:/"._main_lang."/chat/view");
                }
                else {
                    header("Location:/"._main_lang."/questions/view/".$url);
                }
            }
        else{
                View::purerender('/view/msgs/fail.php',array('one'=>'Login failed,check your email or password.'));
            }
        }
        else{
            View::purerender('/view/msgs/fail.php',array('one'=>'Login failed,check your email or password.'));
        }
    }

    public function logout(){
        session_destroy();
        setcookie('uid',"",time()-3600,'/');
        setcookie('pass',"",time()-3600,'/');
        header("Location:/"._main_lang);
    }
    public function register(){
        $name=$_POST['uname'];
        $pass=$_POST['pass'];
        $mail=$_POST['email'];
        if($name==''||ctype_space($name)||$pass==''||ctype_space($pass)||$mail==''||ctype_space($mail)){
            echo json_encode(array(
                'status'=>'blank',
            ));
            exit;
        }
        if(strlen($name)<5||strlen($pass)<5||strlen($mail)<5){
            echo json_encode(array(
                'status'=>'length',
            ));
            exit;
        }
        global $config;
        $hashed=md5($pass.$config['salt']);
        $date=DAT();
        $results=PageModel::get_user_info2($name);
        $results2=PageModel::get_user_info($mail);
        if($results!=null){
            echo json_encode(array(
                'status'=>'name',
            ));
            exit;
        }
        if($results2!=null){
            echo json_encode(array(
                'status'=>'mail',
            ));
            exit;
        }
        if($results2==null&&$results==null){
            PageModel::register_user($name,$hashed,$mail,$date);
            echo json_encode(array(
                'status'=>'done',
            ));
        }
    }

    public function infox(){
        $id=$_POST['iid'];
        $record=PageModel::get_user_info_all_by_user_id($id);
        ob_start();
        require_once (getcwd().'/mvc/view/msgs/totipinfo.php');
        $doe=ob_get_clean();
        echo json_encode($doe);
    }

    public function clear_ntfctn_n(){
        if(isset($_SESSION['uid'])){
            $res=PageModel::clear_notification($_SESSION['uid']);
            echo json_encode($res);
        }
    }
    public function get_user_rate(){
        $uid=$_POST['uid'];
        $rate=PageModel::get_rate($uid);
        echo json_encode($rate);
    }
    public function rate(){
        $rated=$_POST['rated'];
        $rater=$_POST['rater'];
        $rate=$_POST['rate'];
        $res=PageModel::rate_user($rated,$rater,$rate);
        echo json_encode($res);
    }
    public function set_about(){
        if(isset($_SESSION['uid'])){
            $about=$_POST['about'];
            if(strlen($about)>430){
                echo json_encode(0);
            }
            else {
                $uid=$_SESSION['uid'];
                $res=PageModel::set_user_about($about,$uid);
                echo json_encode($res);
            }
        }
    }
    public function add_new_fav_tag(){
        if(isset($_SESSION['uid'])){
            $newtag=$_POST['tag'];
            if($newtag==''||ctype_space($newtag)){
                echo json_encode('s');
            }
            else {
                $newtag=strtolower($newtag);
                $newtag=preg_replace('/[ ]/','',$newtag);
                if($newtag=='js'){
                    $newtag='javascript';
                }
                $uid=$_SESSION['uid'];
                $res=PageModel::add_new_fav_tag_for_user($newtag,$uid);
                if($res){
                    ob_start();
                    require_once (getcwd().'/mvc/view/profile/add-tag.php');
                    $done=ob_get_clean();
                    echo json_encode($done);
                }
                else {
                    echo json_encode($res);
                }
            }
        }
    }
    public function remove_fav_tag(){
        $uid=$_POST['uid'];
        $tag=$_POST['tag'];
        if(isset($_SESSION['uid'])&&$_SESSION['uid']==$uid){
            $res=PageModel::remove_fav_tag_for_user($uid,$tag);
            echo json_encode($res);
        }
    }
}

?>