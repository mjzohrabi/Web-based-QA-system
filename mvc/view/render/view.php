<?php
class View{
    public function __construct()
    {
        //echo "created!";
    }
    public static function main_render($path,$tab=null){
        ob_start();
        require_once(getcwd().'/mvc'.$path);
        $content=ob_get_clean();
        require_once (getcwd()."/maintheme/default.php");
    }
    public static function purerender($filepath,$data=array()){
        ob_start();
        $records=$data;
        require_once(getcwd().'/mvc'.$filepath);
        $content=ob_get_clean();
        require_once (getcwd()."/maintheme/default.php");
    }
}
?>