<?php
class PageController{
    public function __construct()
    {
    }
    public static function getmethods(){
        return get_class_methods('PageController');
    }
    public function administration(){
        if(isset($_SESSION['uid'])){
            if($_SESSION['class']=='administrator'){
                View::purerender('/view/administration/usercontroll.php');
            }
        }
    }
    public function home(){
        if(isset($_GET['tab'])){
            if($_GET['tab']!='interesting'&&$_GET['tab']!='recent'){
                View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
            }
            else{
                View::main_render('/view/main-content/content.php',$_GET['tab']);
            }
        }
        else{
            View::main_render('/view/main-content/content.php','interesting');
        }

    }
    public function register(){
        View::purerender('/view/login/register.php');
    }
    public function login(){
        if(isset($_GET['rd'])){
            $redirect_url=$_GET['rd'];
        }
        else {
            $redirect_url=_main_lang;
        }
        View::purerender('/view/login/login.php',array('url'=>$redirect_url));
    }
    public function search(){
        if(isset($_POST['keyword'])){
            $key=$_POST['keyword'];
            if($key==null||$key==''){
                View::purerender('/view/msgs/fail.php',array('one'=>'Your Keyword is null!'));
            }
            else {
                $results=PageModel::search($key);
                View::purerender('/view/search/search.php',$results);
            }
        }
        else {
            View::purerender('/view/msgs/fail.php',array('one'=>'Your Keyword is null!'));
        }
    }

    public function questions($index=null){
        if($index==null){
            $index=1;
        }
        $total=PageModel::get_all_questions_num();
        $count=15;
        $ceil=ceil($total/$count);
        if($index > $ceil){
            header("Location:/"._main_lang."/page/questions"."/".$ceil);
        }
        else {
            $start=($index-1)*$count;
            view::purerender('/view/question/all-questions.php',array('index'=>$index,'ceil'=>$ceil,'start'=>$start,'count'=>$count));
        }
    }

    public function profile($string){
        //View::purerender('/view/msgs/fail.php',array('one'=>'This section is in development!'));exit;
        $parts=explode('-',$string);
        //print_r($parts);exit;
        $allusrs=PageModel::get_all_users();
        $flag=0;
        for($i=0;$i<count($allusrs);$i++){
            if($parts[0]==$allusrs[$i]['user_id']){
                if(!strcasecmp($parts[1],$allusrs[$i]['user_name'])&&$parts[1]==$allusrs[$i]['user_name']){
                    $flag=1;
                    break;
                }
                if(!strcasecmp($parts[1],$allusrs[$i]['user_name'])&&$parts[1]!=$allusrs[$i]['user_name']){
                    View::purerender('/view/msgs/fail.php',array('one'=>'Content Not Found'));
                }
            }
        }
        if($flag){
            PageModel::profile_views($parts[0]);
            $info=PageModel::get_user_info_all_by_user_id($parts[0]);
            View::purerender('/view/profile/profile.php',$info);
        }
        else{
            View::purerender('/view/msgs/fail.php',array('one'=>'Content Not Found'));
        }
    }

    public function upload($uid,$name){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            exit;
        }
        if(file_exists($_FILES["fileToUpload"]["tmp_name"])){
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                    exit;
                }
            }
            $newname=$uid.'.'.'jpg';
            if (file_exists($target_dir.$newname)) {
                unlink('uploads/'.$newname);
                $uploadOk = 1;
            }
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
                exit;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                exit;
            }
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                exit;
            }
            else {
                $xox=$_FILES["fileToUpload"]["tmp_name"];
                $src = imagecreatefromstring( file_get_contents($xox));
                $dst = imagecreatetruecolor( 300, 300 );
                imagecopyresampled($dst,$src,0,0,0,0,300,300,$check[0],$check[1]);
                imagejpeg($dst,$_FILES["fileToUpload"]["tmp_name"]);
                $don=move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_dir.$newname);
                if($don){
                    header("Location:/"._main_lang."/page/profile/".profile_link($uid,$name));
                }

            }
        }
        else{
            View::purerender('/view/msgs/fail.php',array('one'=>'No file was selected'));
        }
    }
    public function users(){
        $records=PageModel::get_all_users_2();
        View::purerender('/view/users/users.php',$records);
    }
}
?>