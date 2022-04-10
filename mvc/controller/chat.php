<?php
class ChatController{
    public function __construct()
    {
    }
    public static function getmethods(){
        return get_class_methods('ChatController');
    }
    public function view(){
        View::purerender('/view/chat/chat-view.php');
    }
    public function submit_chat(){
        if(isset($_SESSION['uid'])){
            $body=$_POST['body'];
            $uid=$_SESSION['uid'];
            $date=DAT();
            $newbody=filter_for_chat($body);
            $res=PageModel::set_chat($uid,$newbody,$_POST['body'],$date);
            echo json_encode($res);
        }
    }
    public function chats(){
        ob_start();
        require_once (getcwd().'/mvc/view/chat/chat-refresh.php');
        $done=ob_get_clean();
        echo json_encode($done);
    }
    public function get_chat_to_edit(){
        if(isset($_SESSION['uid'])){
            $cid=$_POST['chat_id'];
            $chat=PageModel::get_chat_for_edit($cid);
            if($_SESSION['uid']==$chat['ch_userid']){
                echo json_encode($chat['ch_main']);
            }
        }

    }
    public function edit_chat(){
        if(isset($_SESSION['uid'])){
            $body=$_POST['body'];
            $cid=$_POST['chat_id'];
            $newbody=filter_for_chat($body);
            $res=PageModel::submit_chat_edit($cid,$newbody,$body,$_SESSION['uid']);
            echo json_encode($res);
        }
    }
    public function remove_chat(){
        if(isset($_SESSION['uid'])){
            $cid=$_POST['chat_id'];
            if($_SESSION['class']=='administrator'){
                $res=PageModel::remove_chat_administrator($cid);
                echo json_encode($res);
            }
            else {
                $res=PageModel::remove_chat($cid,$_SESSION['uid']);
                echo json_encode($res);
            }
        }
    }
}
