<script>tinymce.init({ selector: '#specialtxt2',
        height: 200,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
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
<?php
$results=PageModel::get_last_q_edition($records['q_id']);
$title=q_tiltle($records['q_name']);
?>
<div class="view-question">
    <div class="question-total">
        <div class="question-left">
            <p>
                <span onclick="vote('u','q',<?=$records['q_id']?>,<?=$records['asker']?>,<?=$records['q_id']?>)"><img src="/image/arrow-up.png" class="updown-image"></span>
            </p>
            <p>
                <h2 id="q_rate<?=$records['q_id']?>"><?=$records['rate']?></h2>
            </p>
            <p>
                <span onclick="vote('d','q',<?=$records['q_id']?>,<?=$records['asker']?>,<?=$records['q_id']?>)"><img src="/image/arrow-down.png" class="updown-image"></span>
            </p>
        </div>
        <div class="question-right">
            <div class="question-title<?=_css?>">
                <h1><?=$records['q_name']?></h1>
            </div>
            <div class="question-body<?=_css?>">
                <?php
                if($results!=null){
                    echo $results['q_body'];
                }
                else {
                    echo $records['q_body'];
                }
                ?>
            </div>
            <div class="question-tags">
                <?php
                for($j=1;$j<6;$j++){
                    if($records['tag'.$j]!=''){ ?>
                        <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($records['tag'.$j])?>" class="q-tag"><?=$records['tag'.$j]?></a>
                    <?php }
                    ?>
                <?php } ?>
            </div>
            <div class="question-writer<?=_css?>">
                <?php
                echo _asked;
                $current=DAT();
                $Date=$records['q_date'];
                $two=strtotime($Date);
                $one=strtotime($current);
                $don=$one-$two;
                $x=time_calculation($don,$Date);
                echo $x.'<br>';
                ?>
                <div style="display: flex">
                    <img class="mini-img" src="/uploads/<?=$records['asker'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                    <div>
                        <a class="<?=$records['class']?>" id="user-q-a-<?=$records['asker']?>" onmouseover="tooltip_q('q','a',<?=$records['asker']?>)" href="/<?=_main_lang?>/page/profile/<?=profile_link($records['asker'],$records['user_name'])?>"><?=$records['user_name']?></a>
                        <p><span class="q-rep-num" title="reputation score"><?=$records['reputation']?></span></p>
                    </div>
                </div>
            </div>
            <?php
            if($results!=null){
            ?>
            <div class="edition-bar" id="q-edit-bar<?=$records['q_id']?>">
                <div class="question-editors<?=_css?>">
                    <?php
                    echo _edited;
                    $current3=DAT();
                    $Date3=$results['e_date'];
                    $two3=strtotime($Date3);
                    $one3=strtotime($current3);
                    $don3=$one3-$two3;
                    $x3=time_calculation($don3,$Date3);
                    echo $x3.'<br>';
                    ?>
                    <div style="display: flex">
                        <img class="mini-img" src="/uploads/<?=$results['editor_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                        <div>
                            <a class="<?=$results['class']?>" id="user-q-e-<?=$results['editor_id']?>" onmouseover="tooltip_q('q','e',<?=$results['editor_id']?>)" href="/<?=_main_lang?>/page/profile/<?=profile_link($results['editor_id'],$results['user_name'])?>"><?=$results['user_name']?></a>
                            <p><span class="q-rep-num" title="reputation score"><?=$results['reputation']?></span></p>
                        </div>
                    </div>
                    <p><a class="ec-btn" href="/<?=_main_lang?>/questions/question_revisions/<?=$records['q_id']?>"><?=_view_changes?></a></p>
                </div>
            </div>
            <?php } ?>
            <?php
            $qcmnts=PageModel::get_comments_for_q($records['q_id']);
            ?>
            <div class="edit-comment<?=_css?>">
                <span class="ec-btn" onclick="show_cmnts('q',<?=$records['q_id']?>)"><?=_view_comments?></span>
                <span class="ec-btn">(</span><span class="ec-btn" id="q-comments-num<?=$records['q_id']?>"><?=count($qcmnts)?></span><span class="ec-btn">)</span>
            </div>
            <div class="comment-bar<?=_css?>" id="q-comment-bar<?=$records['q_id']?>">
                <?php
                if($qcmnts!=null) {
                    for ($t = 0; $t < count($qcmnts); $t++) { ?>
                        <div id="q-comment<?= $qcmnts[$t]['c_id'] ?>" class="comment-total<?=_css?>">
                            <p class="comment-body">
                                <?= $qcmnts[$t]['c_body'] ?>
                            </p>
                            <p>
                                <?php
                                $current = DAT();
                                $two = strtotime($qcmnts[$t]['c_date']);
                                $one = strtotime($current);
                                $don = $one - $two;
                                $x3 = time_calculation($don, $qcmnts[$t]['c_date']);
                                echo $x3 . '<br>';
                                ?>
                            </p>
                            <a class="<?=$qcmnts[$t]['class']?>" href="/<?= _main_lang ?>/page/profile/<?= profile_link($qcmnts[$t]['cmntr'], $qcmnts[$t]['user_name']) ?>"><?= $qcmnts[$t]['user_name'] ?></a>
                            <?php
                            if(isset($_SESSION['uid'])){
                                if($qcmnts[$t]['cmntr']==$_SESSION['uid']){ ?>
                                    <span class="profile" onclick="remove_comment('q',<?=$qcmnts[$t]['c_id']?>,<?=$records['q_id']?>)"><?=_delete?></span>
                                <?php }
                            }
                            ?>
                        </div>
                    <?php }
                }
                ?>
            </div>
            <div class="edit-comment<?=_css?>">
                <?php
                $url=geturl();
                $urlparts=explode('/',$url);
                if($results!=null){
                    $editedq=1;
                }
                else {
                    $editedq=0;
                }
                ?>
                <a class="ec-btn" href="/<?=_main_lang?>/questions/edit_q/<?=$editedq?>/<?=$records['q_id']?>/<?=$urlparts[count($urlparts)-1]?>"><?=_edit?></a>
                <span class="ec-btn" onclick="draw_input('q',<?=$records['q_id']?>)"><?=_comment?></span>
                <div id="q-commenting-bar<?=$records['q_id']?>" class="c-bar-n">
                    <input type="text" id="q-comment-input<?=$records['q_id']?>" class="c-input"><span class="q-c-btn<?=_css?>" id="q-comment-btn<?=$records['q_id']?>" onclick="post_comment('q',<?=$records['q_id']?>)"><?=_post?></span>
                </div>
            </div>
        </div>
    </div>
    <?php
    $answers=PageModel::get_answers_for_question($records['q_id']);
    $a_count=explode(',',$records['repliers']);
    ?>
    <div class="answer-num<?=_css?>">
        <h2><?=count($a_count)-1?> <?=_answers2?></h2>
    </div>
    <?php
    for($i=0;$i<count($answers);$i++){
        $answer_editions=PageModel::get_last_a_edition($answers[$i]['a_id']);
        ?>
        <div class="answer-total">
            <div class="answer-left">
                <p>
                    <span onclick="vote('u','a',<?=$answers[$i]['a_id']?>,<?=$answers[$i]['replier']?>,<?=$records['q_id']?>)"><img src="/image/arrow-up.png" class="updown-image"></span>
                </p>
                <p>
                <h2 id="a_rate<?=$answers[$i]['a_id']?>"><?=$answers[$i]['rate']?></h2>
                </p>
                <p>
                    <span onclick="vote('d','a',<?=$answers[$i]['a_id']?>,<?=$answers[$i]['replier']?>,<?=$records['q_id']?>)"><img src="/image/arrow-down.png" class="updown-image"></span>
                </p>
                <?php
                if(isset($_SESSION['uid'])){
                    if($_SESSION['uid']==$records['asker']) {
                        if ($answers[$i]['a_id'] == $records['correct_answer']) { ?>
                            <span onclick="set_not_right(<?= $records['q_id'] ?>)"><img title="remove as correct answer" src="/image/check-mark.jpg" class="updown-image"></span>
                        <?php } else {
                            ?>
                            <p>
                                <span onclick="set_right(<?= $records['q_id'] ?>,<?= $answers[$i]['a_id'] ?>)"><img title="choose as a correct answer" src="/image/tick-mark.png" class="updown-image"></span>
                            </p>
                        <?php }
                    }
                    else {
                        if ($answers[$i]['a_id'] == $records['correct_answer']) { ?>
                            <span><img title="The correct answer" src="/image/check-mark.jpg" class="updown-image2"></span>
                        <?php }
                    }
                }
                else {
                    if ($answers[$i]['a_id'] == $records['correct_answer']) { ?>
                    <span><img title="The correct answer" src="/image/check-mark.jpg" class="updown-image2"></span>
                <?php }
                }
                ?>
            </div>
            <div class="question-right">
                <div class="question-body2<?=_css?>">
                    <?php
                    if($answer_editions!=null){
                        echo $answer_editions['a_body'];
                    }
                    else {
                        echo $answers[$i]['a_body'];
                    }
                    ?>
                </div>
                <div class="question-writer2<?=_css?>">
                    <?php
                    echo _answered;
                    $current2=DAT();
                    $Date2=$answers[$i]['a_date'];
                    $two2=strtotime($Date2);
                    $one2=strtotime($current2);
                    $don2=$one2-$two2;
                    $x2=time_calculation($don2,$Date2);
                    echo $x2.'<br>';
                    ?>
                    <div style="display: flex">
                        <img class="mini-img" src="/uploads/<?=$answers[$i]['replier'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                        <div>
                            <a class="<?=$answers[$i]['class']?>" id="user-a-a-<?=$i?>-<?=$answers[$i]['replier']?>" onmouseover="tooltip_a('a','a',<?=$i?>,<?=$answers[$i]['replier']?>)" href="/<?=_main_lang?>/page/profile/<?=profile_link($answers[$i]['replier'],$answers[$i]['user_name'])?>"><?=$answers[$i]['user_name']?></a>
                            <p><span class="q-rep-num" title="reputation score"><?=$answers[$i]['reputation']?></span></p>
                        </div>
                    </div>
                </div>
                <?php
                if($answer_editions!=null){ ?>
                <div class="edition-bar" id="a-edit-bar<?= $answers[$i]['a_id'] ?>">
                    <div class="question-editors<?=_css?>">
                        <?php
                        echo _edited;
                        $current3 = DAT();
                        $Date3 = $answer_editions['e_date'];
                        $two3 = strtotime($Date3);
                        $one3 = strtotime($current3);
                        $don3 = $one3 - $two3;
                        $x3 = time_calculation($don3, $Date3);
                        echo $x3 . '<br>';
                        ?>
                        <div style="display: flex">
                            <img class="mini-img" src="/uploads/<?=$answer_editions['editor_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                            <div>
                                <a class="<?=$answer_editions['class']?>" id="user-a-e-<?=$i?>-<?=$answer_editions['editor_id']?>" onmouseover="tooltip_a('a','e',<?=$i?>,<?=$answer_editions['editor_id']?>)" href="/<?=_main_lang?>/page/profile/<?=profile_link($answer_editions['editor_id'],$answer_editions['user_name'])?>"><?=$answer_editions['user_name']?></a>
                                <p><span class="q-rep-num" title="reputation score"><?=$answer_editions['reputation']?></span></p>
                            </div>
                        </div>
                        <p><a class="ec-btn" href="/<?= _main_lang ?>/questions/answer_revisions/<?= $answers[$i]['a_id'] ?>"><?=_view_changes?></a></p>
                    </div>
                </div>
                <?php
                }
                ?>
                <?php
                $acmnts=PageModel::get_comments_for_a($answers[$i]['a_id']);
                ?>
                <div class="edit-comment<?=_css?>">
                    <span class="ec-btn" onclick="show_cmnts('a',<?=$answers[$i]['a_id']?>)"><?=_view_comments?></span>
                    <span class="ec-btn">(</span><span class="ec-btn" id="a-comments-num<?=$answers[$i]['a_id']?>"><?=count($acmnts)?></span><span class="ec-btn">)</span>
                </div>
                <div class="comment-bar<?=_css?>" id="a-comment-bar<?=$answers[$i]['a_id']?>">
                    <?php
                    if($acmnts!=null) {
                        for ($t = 0; $t < count($acmnts); $t++) { ?>
                            <div id="a-comment<?= $acmnts[$t]['c_id'] ?>" class="comment-total<?=_css?>">
                                <p class="comment-body">
                                    <?= $acmnts[$t]['c_body'] ?>
                                </p>
                                <p>
                                    <?php
                                    $current = DAT();
                                    $two = strtotime($acmnts[$t]['c_date']);
                                    $one = strtotime($current);
                                    $don = $one - $two;
                                    $x3 = time_calculation($don, $acmnts[$t]['c_date']);
                                    echo $x3 . '<br>';
                                    ?>
                                </p>
                                <a class="<?=$acmnts[$t]['class']?>"
                                   href="/<?= _main_lang ?>/page/profile/<?= profile_link($acmnts[$t]['cmntr'], $acmnts[$t]['user_name']) ?>"><?= $acmnts[$t]['user_name'] ?></a>
                                <?php
                                if(isset($_SESSION['uid'])){
                                    if($acmnts[$t]['cmntr']==$_SESSION['uid']){ ?>
                                        <span class="profile" onclick="remove_comment('a',<?=$acmnts[$t]['c_id']?>,<?=$answers[$i]['a_id']?>)"><?=_delete?></span>
                                    <?php }
                                }
                                ?>
                            </div>
                        <?php }
                    }
                    ?>
                </div>
                <?php
                if($answer_editions!=null){
                    $editeda=1;
                }
                else {
                    $editeda=0;
                }
                ?>
                <div class="edit-comment<?=_css?>">
                    <a class="ec-btn" href="/<?=_main_lang?>/questions/edit_a/<?=$editeda?>/<?=$answers[$i]['a_id']?>/<?=$urlparts[count($urlparts)-1]?>"><?=_edit?></a>
                    <span class="ec-btn" id="a-comment<?=$answers[$i]['a_id']?>" onclick="draw_input('a',<?=$answers[$i]['a_id']?>)"><?=_comment?></span>
                    <div id="a-commenting-bar<?=$answers[$i]['a_id']?>" class="c-bar-n">
                        <input type="text" id="a-comment-input<?=$answers[$i]['a_id']?>" class="c-input"><span class="q-c-btn<?=_css?>" id="a-comment-btn<?=$answers[$i]['a_id']?>" onclick="post_comment('a',<?=$answers[$i]['a_id']?>)"><?=_post?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <form class="question-post<?=_css?>" action="/<?=_main_lang?>/questions/submit_answer/<?=$urlparts[count($urlparts)-1]?>" method="post">
        <input id="specialtxt2" name="answer">
        <button type="submit" class="blue-button2"><?=_Post_Your_Answer?></button>
    </form>
</div>
<script>
    $(function(){
        $('title').html("<?=$title?>");
    });
    function show_cmnts(type,id){
        $('#'+type+'-comment-bar'+id).slideToggle('normal');
    }

    function tooltip_q(type1,type2,uid){
        var cords=$('#user-'+type1+'-'+type2+'-'+uid).offset();
        var xleft=cords.left;
        var xtop=cords.top;
        var relative=xtop-$(window).scrollTop();
        var dtop;
        var ttype;
        if(relative<170){
            dtop=25;
            ttype=2
        }
        else{
            dtop=-176;
            ttype=1;
        }
        $('#public-wait').fadeIn('normal').html("<img src='/image/waiting.gif' style='width:45px;height: 15px;'>");
        setTimeout(function(){
            $('#public-wait').fadeOut('normal');
            if($('#user-'+type1+'-'+type2+'-'+uid+':hover').length>0){
                $.ajax('/<?=_main_lang?>/user/infox',{
                    type:'post',
                    dataType:'json',
                    data:{
                        iid:uid
                    },
                    success:function(data){
                        $('#custom-tooltip'+ttype).fadeIn('fast').html(data).css({left:xleft-10,top:xtop+dtop});
                    }
                });
            }
        },850);
        $('#user-'+type1+'-'+type2+'-'+uid).on('mouseout',function(){
            setTimeout(function(){
                if($('#custom-tooltip'+ttype+':hover').length>0){

                }
                else {
                    if($('#user-'+type1+'-'+type2+'-'+uid+':hover').length>0){

                    }
                    else {
                        $('#custom-tooltip'+ttype).fadeOut('slow');
                    }
                }
            },850);
        });
        $('#custom-tooltip'+ttype).hover(function(){},function(){
            setTimeout(function(){
                if($('#custom-tooltip'+ttype+':hover').length>0){

                }
                else {
                    $('#custom-tooltip'+ttype).fadeOut('slow');
                }
            },850);
        });
    }


    function tooltip_a(type1,type2,i,uid){
        var cords=$('#user-'+type1+'-'+type2+'-'+i+'-'+uid).offset();
        var xleft=cords.left;
        var xtop=cords.top;
        var relative=xtop-$(window).scrollTop();
        var dtop;
        var ttype;
        if(relative<170){
            dtop=25;
            ttype=2
        }
        else{
            dtop=-176;
            ttype=1;
        }
        $('#public-wait').fadeIn('normal').html("<img src='/image/waiting.gif' style='width:45px;height: 15px;'>");
        setTimeout(function(){
            $('#public-wait').fadeOut('normal');
            if($('#user-'+type1+'-'+type2+'-'+i+'-'+uid+':hover').length>0){
                $.ajax('/<?=_main_lang?>/user/infox',{
                    type:'post',
                    dataType:'json',
                    data:{
                        iid:uid
                    },
                    success:function(data){
                        $('#custom-tooltip'+ttype).fadeIn('fast').html(data).css({left:xleft-10,top:xtop+dtop});
                    }
                });
            }
        },850);
        $('#user-'+type1+'-'+type2+'-'+i+'-'+uid).on('mouseout',function(){
            setTimeout(function(){
                if($('#custom-tooltip'+ttype+':hover').length>0){

                }
                else {
                    if($('#user-'+type1+'-'+type2+'-'+i+'-'+uid+':hover').length>0){

                    }
                    else {
                        $('#custom-tooltip'+ttype).fadeOut('slow');
                    }
                }
            },850);
        });
        $('#custom-tooltip'+ttype).hover(function(){},function(){
            setTimeout(function(){
                if($('#custom-tooltip'+ttype+':hover').length>0){

                }
                else {
                    $('#custom-tooltip'+ttype).fadeOut('slow');
                }
            },850);
        });
    }

    function vote(method,type,id,owner,q){
        $.ajax('/<?=_main_lang?>/questions/vote',{
            type:'post',
            dataType:'json',
            data:{
                method:method,
                type:type,
                id:id,
                owner:owner,
                q:q
            },
            success:function(data){
                if(data=='1'){
                    if(type=='q'){
                        if(method=='u'){
                            var num=$('#q_rate'+id).html();
                            $('#q_rate'+id).html(+num+1);
                        }
                        if(method=='d'){
                            var num=$('#q_rate'+id).html();
                            $('#q_rate'+id).html(+num-1);
                        }
                    }
                    if(type=='a'){
                        if(method=='u'){
                            var num=$('#a_rate'+id).html();
                            $('#a_rate'+id).html(+num+1);
                        }
                        if(method=='d'){
                            var num=$('#a_rate'+id).html();
                            $('#a_rate'+id).html(+num-1);
                        }
                    }
                }
                if(data=='1') {
                    $('#public-info').fadeIn('normal').html("Your vote was successfully stored!").delay(1500).fadeOut('slow');
                }
                if(data=='0') {
                    $('#public-info').fadeIn('normal').html("You already have voted for this!").delay(1500).fadeOut('slow');
                }
                if(data=='nl') {
                    $('#public-info').fadeIn('normal').html("You must be logged in!").delay(1500).fadeOut('slow');
                }
                if(data=='nu') {
                    $('#public-info').fadeIn('normal').html("You can not vote for yourself!").delay(1500).fadeOut('slow');
                }
            }
        });
    }
    function set_right(qid,aid){
        $.ajax('/<?=_main_lang?>/questions/set_correct_answer',{
            type:'post',
            dataType:'json',
            data:{
                qid:qid,
                aid:aid
            },
            success:function(data){
                if(data){
                    window.location.reload();
                }
            }
        });
    }
    function set_not_right(qid){
        $.ajax('/<?=_main_lang?>/questions/remove_correct_answer',{
            type:'post',
            dataType:'json',
            data:{
                qid:qid
            },
            success:function(data){
                if(data){
                    window.location.reload();
                }
            }
        });
    }
    function draw_input(type,id){
        $('#'+type+'-commenting-bar'+id).slideToggle('fast');
    }
    function post_comment(type,id){
        var parts=window.location.pathname.split('/');
        var req=parts[parts.length-1];
        var body=$('#'+type+'-comment-input'+id).val();
        if(/\S/.test(body)){
            $.ajax('/<?=_main_lang?>/questions/submit_comment',{
                type:'post',
                dataType:'json',
                data:{
                    type:type,
                    id:id,
                    body:body
                },
                success:function(data){
                    if(data[0]=='1'){
                        $(data[1]).prependTo('#'+type+'-comment-bar'+id).show('slow');
                        var num=$('#'+type+'-comments-num'+id).html();
                        $('#'+type+'-comments-num'+id).html(+num+1);
                        $('#'+type+'-comment-input'+id).val('');
                    }
                    else {
                        window.location.replace('/<?=_main_lang?>/page/login/?rd='+req);
                    }
                }
            });
        }
        else {
            $('#public-info').fadeIn('normal').html("comment body can not be empty!").delay(1500).fadeOut('slow');
        }
    }
    function remove_comment(type,id,aq){
        $.ajax('/<?=_main_lang?>/questions/delete_comment',{
            type:'post',
            dataType:'json',
            data:{
                type:type,
                id:id
            },
            success:function(data){
                if(data){
                    $('#'+type+'-comment'+id).hide('slow');
                    var num=$('#'+type+'-comments-num'+aq).html();
                    $('#'+type+'-comments-num'+aq).html(+num-1);
                }
            }
        });
    }
</script>