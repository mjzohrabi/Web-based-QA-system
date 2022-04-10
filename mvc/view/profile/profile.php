<script>tinymce.init({ selector: '#about-input',
        height: 150,
        width:550,
        theme: 'modern',
        plugins: [
            'link preview hr anchor pagebreak',
            'searchreplace wordcount',
            'save contextmenu directionality',
            'template paste textpattern'
        ],
        toolbar1: 'bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        } });
</script>
<div class="profile-total">
    <div class="pro-name-rep">
        <p class="profile-name"><span class="pro-name"><?=$records['user_name']?></span></p>
        <p class="profile-rep"><span class="pro-rep"><?=_reputation?>:<?=$records['reputation']?></span></p>
    </div>
    <div class="profile-pic">
        <img class="profile-img" src="/uploads/<?=$records['user_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
        <?php if(isset($_SESSION['uid'])&&$_SESSION['uid']!=$records['user_id']){ ?>
            <div class="rating">
                <span id="st1" onmouseover="str(1,<?=$_SESSION['uid']?>)" onmouseout="nostr()" onclick="dorate(1,<?=$_SESSION['uid']?>)" class="fa fa-star-o ratecolor"></span><span id="st2" onmouseover="str(2,<?=$_SESSION['uid']?>)" onmouseout="nostr()" onclick="dorate(2,<?=$_SESSION['uid']?>)" class="fa fa-star-o ratecolor"></span><span id="st3" onmouseover="str(3,<?=$_SESSION['uid']?>)" onmouseout="nostr()" onclick="dorate(3,<?=$_SESSION['uid']?>)" class="fa fa-star-o ratecolor"></span><span id="st4" onmouseover="str(4,<?=$_SESSION['uid']?>)" onmouseout="nostr()" onclick="dorate(4,<?=$_SESSION['uid']?>)" class="fa fa-star-o ratecolor"></span><span id="st5" onmouseover="str(5,<?=$_SESSION['uid']?>)" onmouseout="nostr()" onclick="dorate(5,<?=$_SESSION['uid']?>)" class="fa fa-star-o ratecolor"></span>
            </div>
        <?php } else{ ?>
            <div class="rating">
                <span><i id="st1" class="fa fa-star-o ratecolor2"></i><i id="st2" class="fa fa-star-o ratecolor2"></i><i id="st3" class="fa fa-star-o ratecolor2"></i><i id="st4" class="fa fa-star-o ratecolor2"></i><i id="st5" class="fa fa-star-o ratecolor2"></i></span>
            </div>
        <?php }
        if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']){ ?>
            <div>
                <span class="upload-btn" id="edit-about" style="left: -140px;top:20px;"><?=_edit_about?></span>
            </div>
        <?php }
        ?>
        <div class="profile-about">
            <?php
            if($records['about']!=''){
                echo $records['about'];
            }
            else { ?>
                <span class="nth-about-usr"><?=_nothing_yet?></span>
            <?php }
            ?>
        </div>
        <?php
        if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) {
            ?>
            <div id="profile-edit-bar" class="peb<?=_css?>">
                <input id="about-input" style="width: 400px;">
                <span class="black-btn" id="save-about" style="padding: 7px 17px;"><?=_save?></span>
                <span class="black-btn" id="cancel-about" style="top:220px;"><?=_cancel?></span>
            </div>

        <?php } ?>
    </div>
    <?php
    if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) {
        ?>
        <div>
            <form class="img-upload" action="/<?=_main_lang?>/page/upload/<?= $_SESSION['uid'] ?>/<?= $_SESSION['name'] ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <button type="submit" name="submit" class="upload-btn"><?=_upload?></button>
            </form>
        </div>

        <?php
    } ?>
    <div class="q-a-titles<?=_css?>">
        <h2>
            <?php if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) { ?>
                <span class="p-tag<?=_css?>"><?=_Your_Favourite_Tags?></span>
            <?php }
            else { ?>
                <span class="p-tag<?=_css?>"><?=_This_Users_Favourite_Tags?></span>
            <?php }
            ?>
        </h2>
    </div>
    <div class="profile-tag-bar<?=_css?>">
        <div id="main-tags-bar">
            <?php
            if($records['fav_tags']!='') {
                $ftag = explode(',', $records['fav_tags']);
                if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']){ ?>
                    <?php
                    for ($t = 0; $t < count($ftag)-1; $t++) { ?>
                        <span id="tag-total-<?=$ftag[$t]?>">
                                    <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($ftag[$t])?>" class="q-tag"><?= $ftag[$t] ?></a> <span onclick="remove_fav_tag(<?= $records['user_id'] ?>,'<?= $ftag[$t] ?>')" class="tag-remove-btn"><i class="fa fa-remove"></i></span>
                                </span>

                    <?php }?>

                <?php }
                else {
                    for ($t = 0; $t < count($ftag)-1; $t++) { ?>
                        <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($ftag[$t])?>" class="q-tag"><?= $ftag[$t] ?></a>
                    <?php }
                }
            }
            else { ?>
                <span id="no-fav-yet"><?=_No_favourite_tags_yet?></span>
            <?php } ?>
        </div>
        <?php
        if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) {
            ?>
            <div style="position: relative;top:10px;">
                <input type="text" class="c-input2" id="new-tag-input"><span class="upload-btn<?=_css?>" id="add-tag" onclick="add_fav_tag()"><?=_add_ftag?></span>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="q-a-titles<?=_css?>" style="border-bottom: 1px solid #1e1e1e">
        <h2>
            <?php if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) { ?>
                <span class="p-tag<?=_css?>"><?=_Questions_You_Asked?></span>
            <?php }
            else { ?>
                <span class="p-tag<?=_css?>"><?=_Questions_Asked_By_This_User?></span>
            <?php }
            ?>
        </h2>
    </div>
    <div class="profile-asked-q<?=_css?>">
        <?php
        $questions=PageModel::get_user_question($records['user_id']);
        for($i=0;$i<count($questions);$i++){
            $parts=explode(',',$questions[$i]['repliers']);
            $a_num=count($parts)-1;
            if($a_num!=0){
                $bckgrnd='#fffbec';
            }
            else {
                $bckgrnd='white';
            }
            ?>
            <div class="q-body<?=_css?>" style="background-color:<?=$bckgrnd?>">
                <div class="q-body-right">
                    <div class="q-b-r-parts">
                        <p class="q-num"><?=$questions[$i]['rate']?></p>
                        <p class="unanswered"><?=_votes?></p>
                    </div>
                    <?php
                    if($a_num!=0&&$questions[$i]['correct_answer']!=0){
                        $newclass='answered-c';
                    }
                    if($a_num!=0&&$questions[$i]['correct_answer']==0){
                        $newclass='answered-n';
                    }
                    if($a_num==0){
                        $newclass='q-b-r-parts';
                    }
                    ?>
                    <div class="<?=$newclass?>">
                        <p class="q-num">
                            <?=$a_num?>
                        </p>
                        <p class="unanswered"><?=_answers?></p>
                    </div>
                    <div class="q-b-r-parts">
                        <p class="q-num"><?=$questions[$i]['views']?></p>
                        <p class="unanswered"><?=_views?></p>
                    </div>
                </div>
                <div class="q-body-left<?=_css?>">
                    <div style="position: relative;">
                        <a class="q-title" href="/<?=_main_lang?>/questions/view/<?=topic_link($questions[$i]['q_id'],$questions[$i]['q_name'])?>"><?=$questions[$i]['q_name']?></a>
                    </div>
                    <div style="position: relative;display: flex;">
                        <div style="position: relative;padding: 7px 0;">
                            <p>
                                <?php
                                for($j=1;$j<6;$j++){
                                    if($questions[$i]['tag'.$j]!=''){ ?>
                                        <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($questions[$i]['tag'.$j])?>" class="q-tag"><?=$questions[$i]['tag'.$j]?></a>
                                    <?php }
                                    ?>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
    <br>
    <div class="q-a-titles<?=_css?>" style="border-bottom: 1px solid #1e1e1e">
        <h2>
            <?php if(isset($_SESSION['uid'])&&$_SESSION['uid']==$records['user_id']) { ?>
                <span class="p-tag<?=_css?>"><?=_Questions_You_Have_Answered?></span>
            <?php }
            else { ?>
                <span class="p-tag<?=_css?>"><?=_Questions_Answered_By_This_User?></span>
            <?php }
            ?>
        </h2>
    </div>

    <div class="profile-asked-q<?=_css?>">
        <?php
        $parts=explode(',',$records['answered_q']);
        $nums=array_count_values($parts);
        $unique=array_unique($parts);
        for($t=0;$t<count($parts);$t++){
            if(isset($unique[$t])){
                if($unique[$t]!=''){
                    $question=PageModel::get_question_for_profile($unique[$t]);
                    $partsx=explode(',',$question['repliers']);
                    $a_num=count($partsx)-1;
                    if($a_num!=0){
                        $bckgrnd='#fffbec';
                    }
                    else {
                        $bckgrnd='white';
                    }
                    ?>
                    <div class="q-body<?=_css?>" style="background-color:<?=$bckgrnd?>">
                        <div class="q-body-right">
                            <div class="q-b-r-parts">
                                <p class="q-num"><?=$question['rate']?></p>
                                <p class="unanswered"><?=_votes?></p>
                            </div>
                            <?php
                            if($a_num!=0&&$question['correct_answer']!=0){
                                $newclass='answered-c';
                            }
                            if($a_num!=0&&$question['correct_answer']==0){
                                $newclass='answered-n';
                            }
                            if($a_num==0){
                                $newclass='q-b-r-parts';
                            }
                            ?>
                            <div class="<?=$newclass?>">
                                <p class="q-num">
                                    <?=$a_num?>
                                </p>
                                <p class="unanswered"><?=_answers?></p>
                            </div>
                            <div class="q-b-r-parts">
                                <p class="q-num"><?=$question['views']?></p>
                                <p class="unanswered"><?=_views?></p>
                            </div>
                        </div>
                        <div class="q-body-left<?=_css?>">
                            <div style="position: relative;">
                                <a class="q-title" href="/<?=_main_lang?>/questions/view/<?=topic_link($question['q_id'],$question['q_name'])?>"><?=$question['q_name']?></a>
                            </div>
                            <p>
                            <h3><?=$nums[$question['q_id']]._answers2?></h3>
                            </p>
                            <div style="position: relative;display: flex;">
                                <div style="position: relative;padding: 7px 0;">
                                    <p>
                                        <?php
                                        for($j=1;$j<6;$j++){
                                            if($question['tag'.$j]!=''){ ?>
                                                <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($question['tag'.$j])?>" class="q-tag"><?=$question['tag'.$j]?></a>
                                            <?php }
                                            ?>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                else {
                    continue;
                }
            }
            else {
                continue;
            }
        }
        ?>
    </div>
</div>

<script>
    var throughoutrate;
    $(function(){
        getratejs();
        $('title').html('User:'+'<?=$records['user_name']?>');
    });
    function getratejs(){
        $.ajax('/<?=_main_lang?>/user/get_user_rate',{
            type:'post',
            dataType:'json',
            data:{
                uid:<?=$records['user_id']?>
            },
            success:function(data){
                throughoutrate=Math.ceil(data);
                for(var t=1;t<=throughoutrate;t++){
                    $('#st' + t).removeClass("fa-star-o");
                    $('#st' + t).addClass("fa-star");
                }
            }
        });
    }
    function dorate(i,uid){
        $.ajax('/<?=_main_lang?>/user/rate',{
            type:'post',
            dataType:'json',
            data: {
                rated:<?=$records['user_id']?>,
                rater: uid,
                rate:i
            },
            success:function(data){
                if(data=='n'){
                    $('#public-info').html('You have already rated this user!').fadeIn('normal').delay(1000).fadeOut('normal');
                }
                else {
                    getratejs();
                }
            }
        });
    }
    function nostr(){
        for(var a=1;a<=throughoutrate;a++){
            if($('#st'+a).hasClass("fa-star-o")){
                $('#st' + a).removeClass("fa-star-o");
                $('#st' + a).addClass("fa-star");
            }
        }
        var n=+throughoutrate+1;
        for(var t=n;t<=5;t++){
            if($('#st'+t).hasClass("fa-star")){
                $('#st' + t).removeClass("fa-star");
                $('#st' + t).addClass("fa-star-o");
            }
        }
    }
    function str(i,uid){
        for(var x=1;x<=i;x++) {
            if($('#st'+x).hasClass("fa-star-o")){
                $('#st' + x).removeClass("fa-star-o");
                $('#st' + x).addClass("fa-star");
            }
        }
        var p=i+1;
        for(var m=p;m<=5;m++){
            if($('#st'+m).hasClass("fa-star")){
                $('#st' + m).removeClass("fa-star");
                $('#st' + m).addClass("fa-star-o");
            }
        }
    }
    $('#edit-about').on('click',function(){
        var info=$('.profile-about').html();
        $('#profile-edit-bar').fadeIn('slow');
        tinymce.get('about-input').setContent(info);
    });
    $('#cancel-about').on('click',function(){
        $('#profile-edit-bar').fadeOut('slow');
    });
    $('#save-about').on('click',function(){
        var about=$('#about-input').val();
        //alert(about.length);
        if(about.length>430){
            $('#public-info').html('Your about length can not be more than 450 characters!').fadeIn('normal').delay(1000).fadeOut('normal');
        }
        else {
            $.ajax('/<?=_main_lang?>/user/set_about',{
                type:'post',
                dataType:'json',
                data:{
                    about:about
                },
                success:function(data){
                    if(data){
                        $('.profile-about').html(about);
                        $('#profile-edit-bar').fadeOut('slow');
                        tinymce.get('about-input').setContent('');
                    }
                    if(!data){
                        $('#public-info').html('Your about length can not be more than 450 characters!').fadeIn('normal').delay(1000).fadeOut('normal');
                    }
                }
            });
        }
    });
    function add_fav_tag(){
        var newtag=$('#new-tag-input').val();
        $.ajax('/<?=_main_lang?>/user/add_new_fav_tag',{
            type:'post',
            dataType:'json',
            data:{
                tag:newtag
            },
            success:function(data){
                if(data=='s'){
                    $('#public-info').html('Tag can not be empty or null!').fadeIn('normal').delay(1000).fadeOut('normal');
                }
                if(!data) {
                    $('#public-info').html('This is already in your favourites!').fadeIn('normal').delay(1000).fadeOut('normal');
                }
                else {
                    $('#no-fav-yet').fadeOut('normal');
                    $(data).appendTo('#main-tags-bar').fadeIn('slow');
                    $('#new-tag-input').val('');
                }

            }
        });
    }
    function remove_fav_tag(uid,tag){
        $.ajax('/<?=_main_lang?>/user/remove_fav_tag',{
            type:'post',
            dataType:'json',
            data:{
                uid:uid,
                tag:tag
            },
            success:function(data){
                if(data){
                    $('#tag-total-'+tag).fadeOut('normal');
                }
            }
        })
    }
</script>