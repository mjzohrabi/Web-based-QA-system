<?php
global $config;
session_set_cookie_params(0);
session_start();
require_once(getcwd().'/system/common.php');
require_once(getcwd().'/system/config.php');
require_once(getcwd().'/system/db.php');
require_once(getcwd().'/mvc/view/render/view.php');
require_once(getcwd().'/mvc/model/mpage.php');
require_once(getcwd().'/mvc/controller/page.php');
require_once(getcwd().'/mvc/controller/user.php');
require_once(getcwd().'/mvc/controller/question.php');
require_once(getcwd().'/mvc/controller/chat.php');
?>