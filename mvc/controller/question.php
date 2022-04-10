<?php
class QuestionsController{
    public function __construct()
    {
    }
    public static function getmethods(){
        return get_class_methods('QuestionsController');
    }
    public function ask(){
        View::main_render('/view/question/ask-question.php');
    }
    public function view($url){
        $parts=explode('-',$url);
        $newurl=mb_convert_encoding(urldecode($url),'HTML-ENTITIES','utf-8');
        //echo $newurl;exit;
        $result=PageModel::get_question_to_view($parts[0]);

        //echo $converted;exit;
        $d=preg_replace('/[?]/','',$result['q_name']);
        $a=preg_replace('/[@$%^&:<>=_]/','',$d);
        $g=preg_replace('/[#]/','-sharp',$a);
        $r=preg_replace('/[+]/','-plus',$g);
        $w=preg_replace('/[*]/','',$r);
        $w1=preg_replace('/\[/','',$w);
        $w2=preg_replace('/\]/','',$w1);
        $e=preg_replace("/[{}\.!()]/",'',$w2);
        $y=preg_replace("/\\\\/",'',$e);
        $u=str_replace('/','',$y);
        $q=preg_replace("/'/",'',$u);
        $v=preg_replace('/"/','',$q);
        $f=preg_replace('/[ ]/','-',$v);
        $converted=mb_convert_encoding($f,'HTML-ENTITIES','utf-8');
        //echo $converted;exit;
        $parts2=explode('-',$converted);
        if($parts2[count($parts2)-1]==''){
            for($i=0;$i<count($parts2);$i++){
                if($parts2[$i]!=''){
                    $newparts[$i]=$parts2[$i];
                }
            }
            $new=implode('-',$newparts);
        }
        else{
            $new=$converted;
        }
        $new=$parts[0].'-'.$new;
        //echo $new;exit;
        if($newurl==$new){
            View::purerender('/view/question/view-question.php',$result);
        }
        else {
            View::purerender('/view/msgs/fail.php',array('one'=>'Such question does not exist!'));
            exit;
        }
    }
    public function tag($tag,$index=null){
        $g=preg_replace('/-sharp/','#',$tag);
        $newtag=preg_replace('/-plus/','+',$g);
        $newtag=preg_replace('/[ ]/','',$newtag);
        if($newtag=='js'){
            header("Location:/"._main_lang."/questions/tag/javascript");
        }
        if($index==null){
            $index=1;
        }
        $total=PageModel::get_tagged_number($newtag);
        if($total==0){
            View::purerender('/view/msgs/fail.php',array('one'=>'No such question tagged with '.$newtag.'!'));
            exit;
        }
        $count=8;
        $ceil=ceil($total/$count);
        if($index > $ceil){
            header("Location:/"._main_lang."/questions/tag/".$tag."/".$ceil);
        }
        else {
            $start=($index-1)*$count;
            view::purerender('/view/question/view-tagged.php',array('tag'=>$newtag,'index'=>$index,'ceil'=>$ceil,'start'=>$start,'count'=>$count));
        }
    }
    public function submit_question(){
        if(isset($_SESSION['uid'])){
            $name=$_POST['ask_title'];
            $body=$_POST['ask_body'];
            $tags=$_POST['ask_tags'];

            if($body==''||ctype_space($body)||$name==''||ctype_space($name)){
                View::purerender('/view/msgs/fail.php',array('one'=>'You can not leave title and body fields blank!'));
                exit;
            }
            if(ctype_space($tags)){
                View::purerender('/view/msgs/fail.php',array('one'=>'You can set space as a tag!'));
                exit;
            }
            $tagparts=explode(',',$tags);
            for($i=0;$i<count($tagparts);$i++){
                if($tagparts[$i]!=''&&!ctype_space($tagparts[$i])){
                    $tagparts[$i]=strtolower($tagparts[$i]);
                    $tagparts[$i]=preg_replace('/[ ]/','',$tagparts[$i]);
                }
                if($tagparts[$i]=='js'){
                    $tagparts[$i]='javascript';
                }
            }
            $newtags=implode(',',$tagparts);
            $date=DAT();
            $result=PageModel::submit_question($name,$body,$date,$newtags,$_SESSION['uid']);
            if($result){
                header('Location: /'._main_lang);
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=ask");
        }
    }
    public function submit_answer($url){
        $parts=explode('-',$url);
        if(isset($_SESSION['uid'])){
            if(!ctype_space($_POST['answer'])){
                $body=$_POST['answer'];
                $date=DAT();
                $result=PageModel::submit_answer($parts[0],$body,$_SESSION['uid'],$date);
                if($result){
                    header("Location:/"._main_lang."/questions/view/".$url);
                }
            }
            else {
                header("Location:/"._main_lang."/questions/view/".$url);
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=".$url);
        }

    }
    public function edit_q($if,$qid,$url){
        if(isset($_SESSION['uid'])){
            if($if){
                $result=PageModel::get_last_edited_for_edit_q($qid);
            }
            else {
                $result=PageModel::get_q_body_for_edit_q($qid);
            }
            if($result!=null){
                View::purerender('/view/question/editq.php',$result);
            }
            else {
                View::purerender('/view/msgs/fail.php',array('one'=>'Such question does not exist!'));
                exit;
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=".$url);
        }

    }
    public function submit_edit_q($url){
        $parts=explode('-',$url);
        if(isset($_SESSION['uid'])){
            $new=$_POST['edited'];
            $date=DAT();
            $result=PageModel::submit_edit_q($parts[0],$new,$_SESSION['uid'],$date);
            if($result){
                header("Location:/"._main_lang."/questions/view/".$url);
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=".$url);
        }
    }
    public function question_revisions($main){
        $results=PageModel::get_edited_n_original_q($main);
        View::purerender('/view/question/compare-q.php',$results);
    }

    public function edit_a($if,$aid,$url){
        if(isset($_SESSION['uid'])){
            if($if){
                $result=PageModel::get_last_edited_for_edit_a($aid);
            }
            else {
                $result=PageModel::get_a_body_for_edit_a($aid);
            }
            if($result!=null){
                View::purerender('/view/question/edita.php',$result);
            }
            else {
                View::purerender('/view/msgs/fail.php',array('one'=>'Such answer does not exist!'));
                exit;
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=".$url);
        }

    }
    public function submit_edit_a($aid,$url){
        if(isset($_SESSION['uid'])){
            $new=$_POST['edited'];
            $date=DAT();
            $result=PageModel::submit_edit_a($aid,$new,$_SESSION['uid'],$date);
            if($result){
                header("Location:/"._main_lang."/questions/view/".$url);
            }
        }
        else {
            header("Location:/"._main_lang."/page/login/?rd=".$url);
        }
    }
    public function answer_revisions($main){
        $results=PageModel::get_edited_n_original_a($main);
        View::purerender('/view/question/compare-a.php',$results);
    }
    public function vote(){
        $method=$_POST['method'];
        $type=$_POST['type'];
        $id=$_POST['id'];
        $owner=$_POST['owner'];
        $q=$_POST['q'];
        if(isset($_SESSION['uid'])){
            if($owner!=$_SESSION['uid']){
                if($type=='q'){
                    $res=PageModel::vote_q($method,$_SESSION['uid'],$id,$owner,$q);
                    if($res){
                        echo json_encode('1');
                    }
                    else {
                        echo json_encode('0');
                    }
                }
                if($type=='a'){
                    $res=PageModel::vote_a($method,$_SESSION['uid'],$id,$owner,$q);
                    echo json_encode($res);
                }
            }
            else {
                echo json_encode('nu');
            }
        }
        else {
            echo json_encode('nl');
        }
    }
    public function submit_comment(){
        $type=$_POST['type'];
        $id=$_POST['id'];
        $body=$_POST['body'];
        $class=$_SESSION['class'];
        $date=DAT();
        if(isset($_SESSION['uid'])){
            $uid=$_SESSION['uid'];
            $name=$_SESSION['name'];
            if($type=='q'){
                $res=PageModel::submit_comment_q($uid,$id,$body,$date);
            }
            if($type=='a'){
                $res=PageModel::submit_comment_a($uid,$id,$body,$date);
            }
            if($res){
                ob_start();
                require_once (getcwd().'/mvc/view/question/add-comment.php');
                $done[1]=ob_get_clean();
                $done[0]='1';
                echo json_encode($done);
            }
        }
        else {
            $done[0]='0';
            $done[1]='';
            echo json_encode($done);
        }
    }
    public function set_correct_answer(){
        if(isset($_SESSION['uid'])){
            $uid=$_SESSION['uid'];
            $qid=$_POST['qid'];
            $aid=$_POST['aid'];
            $res=PageModel::set_correct_answer($uid,$qid,$aid);
            echo json_encode($res);
        }
        else {
            View::purerender('/view/msgs/fail.php',array('one'=>'You are no allowed to edit questions with out being logged in!'));
            exit;
        }
    }
    public function remove_correct_answer(){
        if(isset($_SESSION['uid'])){
            $uid=$_SESSION['uid'];
            $qid=$_POST['qid'];
            $res=PageModel::remove_correct_answer($uid,$qid);
            echo json_encode($res);
        }
        else {
            View::purerender('/view/msgs/fail.php',array('one'=>'You are no allowed to edit questions with out being logged in!'));
            exit;
        }
    }
    public function delete_comment(){
        $type=$_POST['type'];
        $id=$_POST['id'];
        if(isset($_SESSION['uid'])){
            $uid=$_SESSION['uid'];
            if($type=='q'){
                $res=PageModel::remove_comment_q($uid,$id);
            }
            if($type=='a'){
                $res=PageModel::remove_comment_a($uid,$id);
            }
            if($res){
                echo json_encode($res);
            }
        }
    }
}
?>