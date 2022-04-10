<html>
<title>Ask Question</title>
<head>
    <meta name="description" content="aks your questions about developing,tag your questions,answer questions,vote up,vote down,rate users">
    <meta name="keywords" content="question,answer,vote up,vote down,tagging questions,rate users,developing">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/css/stylex.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
    <script type="text/javascript" src="/tinymce/tinymce.min.js"></script>
</head>
<body>
<div id="public-info"></div>
<div id="custom-tooltip1"></div>
<div id="custom-tooltip2"></div>
<div id="public-wait"></div>
<div class="header-wrapper" id="hw-w">
    <div class="header-container<?=_css?>">
        <p>
            <a href="/<?=_main_lang?>">
                <img src="/image/stkovrflw.png" class="logo-image">
            </a>
        </p>
        <p>
            <a href="/<?=_main_lang?>/page/questions" class="hw-buttons<?=_css?>"><?=_questions?></a>
        </p>
        <p>
            <a href="/<?=_main_lang?>/page/users" class="hw-buttons<?=_css?>"><?=_users?></a>
        </p>
        <p>
            <a href="/<?=_main_lang?>/chat/view" class="hw-buttons<?=_css?>"><?=_chat?></a>
        </p>
        <p>
            <form action="/<?=_main_lang?>/page/search" method="post">
                <input type="text" id="search-bar" placeholder="<?=_search?>" name="keyword" class="search-box<?=_css?>">
                <button type="submit" class="blue-button<?=_css?>">
                    <img src="/image/search.png" class="search-btn-img">
                </button>
            </form>
        </p>
        <div id="select-lang<?=_css?>">
            <span class="lang-btn"><?=_language?></span>
            <ul style="position: relative;display: none;top:5px;" id="lang-menu">
                <li onclick="change_lang('en')" class="lang-item"><?=_english?></li>
                <li onclick="change_lang('fa')" class="lang-item"><?=_persian?></li>
            </ul>
        </div>
        <div class="ask-bar<?=_css?>">
            <a href="/<?=_main_lang?>/questions/ask" class="ask-main-btn"><?=_ask_a_question?></a>
        </div>
        <?php
        if(isset($_SESSION['uid'])){
            if($_SESSION['class']=='administrator'){ ?>
                <div class="adm-bar<?=_css?>">
                    <a href="/<?=_main_lang?>/page/administration" class="administration"><?=_administration?></a>
                </div>
            <?php }
        }
        if(isset($_SESSION['uid'])){
            $notf=PageModel::get_user_notification($_SESSION['uid']);
            ?>
            <div class="hw-rightest<?=_css?>">
                <i class="fa fa-bell-o bell" id="ringer" onclick="tgl_off(<?=$notf['notf_num']?>)"></i>
                <div>
                    <?php if($notf['notf_num']!=0){ ?>
                        <span id="notf-num" class="notf-num-style<?=_css?>"><?=$notf['notf_num']?></span>
                    <?php } ?>
                </div>
                <div id="go-away">
                    <div id="notf-bar" class="notf<?=_css?>">
                        <div class="notf-header">
                            <h4><?=_achievements?></h4><span><?=only_time()?></span>
                        </div>
                        <div class="notf-body<?=_css?>">
                            <?php
                            if($notf['notification']!='') {
                                $nparts = explode(',', $notf['notification']);
                                $count = count($nparts);
                                if ($count > 5) {
                                    for ($i = $count - 2; $i >= $count - 6; $i--) {
                                        $new = explode('/', $nparts[$i]);
                                        $uname = PageModel::get_user_name($new[0]);
                                        $question = PageModel::get_question_name($new[1]);
                                        if ($new[2]) {
                                            $like = _voted_up;
                                        }
                                        if (!$new[2]) {
                                            $like = _voted_down;
                                        }
                                        ?>

                                        <p class="notf-main"><a class="profile"
                                                                href="/<?= _main_lang ?>/page/profile/<?= profile_link($new[0], $uname) ?>"><?= $uname ?></a><?= ' ' . $like ?>
                                            <?=_on?> <a class="profile"
                                                            href="/<?= _main_lang ?>/questions/view/<?= topic_link($new[1], $question) ?>"><?= $question ?></a>
                                        </p>
                                    <?php }
                                } else {
                                    for ($i = $count - 2; $i >= 0; $i--) {
                                        $new = explode('/', $nparts[$i]);
                                        $uname = PageModel::get_user_name($new[0]);
                                        $question = PageModel::get_question_name($new[1]);
                                        if ($new[2]) {
                                            $like = _voted_up;
                                        }
                                        if (!$new[2]) {
                                            $like = _voted_down;
                                        }
                                        ?>
                                        <div style="display: flex">
                                            <img src="/image/orange.png" class="notf-circle">
                                            <p class="notf-main">
                                                <a class="profile"
                                                   href="/<?= _main_lang ?>/page/profile/<?= profile_link($new[0], $uname) ?>"><?= $uname ?></a><?= ' ' . $like ?>
                                                <?=_on?> <a class="profile"
                                                      href="/<?= _main_lang ?>/questions/view/<?= topic_link($new[1], $question) ?>"><?= $question ?></a>
                                            </p>
                                        </div>
                                    <?php }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="/<?=_main_lang?>/page/profile/<?=profile_link($_SESSION['uid'],$_SESSION['name'])?>">
                    <img class="hw-pic<?=_css?>" src="/uploads/<?=$_SESSION['uid'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                </a>
                <p>
                    <a href="/<?=_main_lang?>/user/logout" class="hw-buttons2<?=_css?>"><?=_logout?></a>
                </p>
            </div>
            <?php
        }
        else { ?>
            <p class="hw-right<?=_css?>">
                <a href="/<?=_main_lang?>/page/login" class="hw-buttons<?=_css?>"><?=_login?></a>
            </p>
            <p class="hw-right<?=_css?>">
                <a href="/<?=_main_lang?>/page/register" class="blue-button3<?=_css?>"><?=_sign_up?></a>
            </p>
        <?php }
        ?>
    </div>
</div>
<div class="header-wrapper" id="hw-m" style="display: flex">
    <div class="m-header-container<?=_css?>" id="hw-m-m">
        <a><img src="/image/menu.png" class="logo-image" id="menu"></a>
        <div class="collapse-menu">
            <a href="/<?=_main_lang?>" class="m-a"><?=_home?></a></li>
            <a href="/<?=_main_lang?>/page/questions" class="m-a"><?=_all_questions?></a>
            <?php
            if(isset($_SESSION['uid'])){ ?>
                <a href="/<?=_main_lang?>/page/profile/<?=profile_link($_SESSION['uid'],$_SESSION['name'])?>" class="m-a"><?=$_SESSION['name']?></a>
                <a href="/<?=_main_lang?>/user/logout" class="m-a"><?=_logout?></a>
            <?php }
            else { ?>
                <a href="/<?=_main_lang?>/page/login" class="m-a"><?=_login?></a>
                <a href="/<?=_main_lang?>/page/register" class="m-a"><?=_sign_up?></a>
            <?php }
            ?>
            <a href="/<?=_main_lang?>/page/users" class="m-a"><?=_users?></a>
            <a href="/<?=_main_lang?>/questions/ask" class="m-a"><?=_ask_a_question?></a>
            <?php
            if(isset($_SESSION['uid'])){
                if($_SESSION['class']=='administrator'){ ?>
                    <a href="/<?=_main_lang?>/page/administration" class="m-a"><?=_administration?></a>
                <?php }
            }
            ?>
            <a href="/<?=_main_lang?>/chat/view" class="m-a"><?=_chat?></a>
            <a href="#" onclick="change_lang('en')" class="m-a"><?=_english?></a>
            <a href="#" onclick="change_lang('fa')" class="m-a"><?=_persian?></a>
        </div>
    </div>
    <form action="/<?=_main_lang?>/page/search" method="post" style="position: relative;left: 300px;">
        <input type="text" id="search-bar" placeholder="<?=_search?>" name="keyword" class="search-box">
        <button type="submit" class="blue-button">
            <img src="/image/search.png" class="search-btn-img">
        </button>
    </form>
</div>
<div id="main-content-default">
    <?=$content?>
    <div style="position: relative;top:50px;height: 100px;width: 10px;"></div>
</div>

</body>
</html>
<script>
    var mdl=document.getElementById('go-away');
    window.onclick=function(e) {
        if (e.target == mdl) {
            $('#go-away').fadeOut('normal');
            if($('#ringer').hasClass('bell-bck')){
                $('#ringer').removeClass('bell-bck');
            }
            else {
                $('#ringer').addClass('bell-bck');
            }
        }
    };
    $('#hw-m-m').on('click',function(){
        $('.collapse-menu').animate({width:"toggle",height:"toggle"},400);
        if($('#menu').hasClass('bell-bck')){
            $('#menu').removeClass('bell-bck');
        }
        else {
            $('#menu').addClass('bell-bck');
        }
    });
    //alert(document.documentElement.clientWidth);
    $(function(){
        if(document.documentElement.clientWidth<1148){
            $('#hw-w').hide();
            $('#hw-m').show();
        }
        else {
            $('#hw-w').show();
            $('#hw-m').hide();
        }
    });
    window.onresize=function(event){
        //alert(document.documentElement.clientWidth);
        if(document.documentElement.clientWidth<1148){
            $('#hw-w').hide();
            $('#hw-m').show();
        }
        if(document.documentElement.clientWidth>1148){
            $('#hw-w').show();
            $('#hw-m').hide();
        }
    };
    $('#select-lang').hover(function(){
       $('#lang-menu').show();
    },function(){
        $('#lang-menu').hide();
    });
    $('#select-lang-fa').hover(function(){
        $('#lang-menu').show();
    },function(){
        $('#lang-menu').hide();
    });
    function change_lang(lang){
        var url=window.location.pathname;
        var parts=url.split('/');
        parts[1]=lang;
        var newurl=parts.join('/');
        window.location.replace(newurl);
    }
    $('#ringer').on('click',function(){
        $('#go-away').fadeToggle('normal');
        if($('#ringer').hasClass('bell-bck')){
            $('#ringer').removeClass('bell-bck');
        }
        else {
            $('#ringer').addClass('bell-bck');
        }
    });
    function tgl_off(num){
        if(num){
            $.ajax('/<?=_main_lang?>/user/clear_ntfctn_n',{
                type:'post',
                dataType:'json',
                success:function(data){
                    if(data){
                        $('#notf-num').fadeOut('normal');
                        $('#ringer').attr('onclick','tgl_off(0)');
                    }
                }
            });
        }
    }
</script>