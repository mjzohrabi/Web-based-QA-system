<?php
require_once(getcwd()."/system/main.php");
/*$db=Db::getInstance();
for($i=0;$i<50;$i++){
    $db->insert("INSERT INTO `stackoverflow`.`questions` (`q_id`, `q_name`, `q_body`, `asker`, `repliers`, `tag1`, `tag2`, `tag3`, `tag4`, `tag5`) VALUES (NULL, 'how can i do that??', '<p>simplescxdasdsadas</p>', '2', '', 'python', 'jquery', 'sql', 'php', '');");
}
exit;*/
//echo geturl();exit;
if(!isset($_SESSION['mail'])){
    if(isset($_COOKIE['uid'])){
        auto_login($_COOKIE['uid'],$_COOKIE['pass'],geturl());
    }
}
//print_r($_SESSION);exit;
date_default_timezone_set("Asia/Tehran");
$uri=geturl();
//echo $uri;
$parts = explode('/', $uri);
//print_r($parts);exit;
if($parts[1]=='en'){
    require_once (getcwd().'/system/local-en.php');
}
if($parts[1]=='fa'){
    require_once (getcwd().'/system/local-fa.php');
}
if($parts[1]==''){
    require_once (getcwd().'/system/local-en.php');
    $uri='/en';
}
if($parts[1]!='fa' && $parts[1]!='en' &&$parts[1]!=''){
    require_once (getcwd().'/system/local-en.php');
    View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
    exit;
}
if(count($parts)>2&&$parts[2]==''){
    View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
    exit;
}
if(count($parts)==3){
    View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
    exit;
}
//print_r($parts);exit;
if($uri!='/fa'&&$uri!='/en'){
    $parts = explode('/', $uri);
    //print_r($parts);exit;
    $controller = $parts[2];

    if(($controller!='page'&&$controller!='')&&($controller!='user'&&$controller!='')&&($controller!='questions'&&$controller!='')&&($controller!='chat'&&$controller!='')){
        View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
        exit;
    }
    $method = $parts[3];
    $classmethods=array();
    $classmethods2=array();
    $classmethods3=array();
    $classmethods=PageController::getmethods();
    $classmethods2=UserController::getmethods();
    $classmethods3=QuestionsController::getmethods();
    $classmethods4=ChatController::getmethods();
    $mthdflag=0;
    for($i=0;$i<count($classmethods);$i++){
        if($method==$classmethods[$i]){
            $mthdflag=1;
            break;
        }
    }
    if(!$mthdflag){
        for($i=0;$i<count($classmethods2);$i++){
            if($method==$classmethods2[$i]){
                $mthdflag=1;
                break;
            }
        }
    }
    if(!$mthdflag){
        for($i=0;$i<count($classmethods3);$i++){
            if($method==$classmethods3[$i]){
                $mthdflag=1;
                break;
            }
        }
    }
    if(!$mthdflag){
        for($i=0;$i<count($classmethods4);$i++){
            if($method==$classmethods4[$i]){
                $mthdflag=1;
                break;
            }
        }
    }
    $params=array();
    if($mthdflag==1){
        for ($i=4;$i<count($parts);$i++) {
            $params[$i-4] = $parts[$i];
        }
        //print_r($params);exit;
        $classname = ucfirst($controller) . 'Controller';
        $contfilepath =getcwd().'/mvc/controller/' . $controller . '.php';
        //require_once($contfilepath);
        $getinst = new $classname;
        call_user_func_array(array($getinst,$method),$params);
    }
    else if($mthdflag==0){
        View::purerender('/view/msgs/fail.php',array('one'=>'Sorry we could not find the content You were looking for'));
    }
}
else {
    View::main_render('/view/main-content/content.php','recent');
}
?>