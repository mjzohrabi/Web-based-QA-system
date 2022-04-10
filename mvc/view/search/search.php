<div class="main-content-left">
    <div class="main-content-wrapper<?=_css?>">
        <span style="font-size: 15pt;"><?=_search_results?></span>
        <div class="main-content-wrapper-inner<?=_css?>">
            <span onclick="search_tabs('q','u')" id="s_q_tab" class="tab-open"><?=_questions2?></span>
            <span onclick="search_tabs('u','q')" id="s_u_tab" class="tab-close"><?=_users2?></span>
        </div>
    </div>
    <div id="content-switchable">

    </div>
    <div id="q-switchable" class="none">
        <?php
        if($records[1]==null){ ?>
            <div class="s-not-found">
                No Questions Were Found
            </div>
        <?php }
        else {
            for ($i = 0; $i < count($records[1]); $i++) { ?>
                <div class="q-body<?= _css ?>">
                    <div class="q-body-right">
                        <div class="q-b-r-parts">
                            <p class="q-num"><?= $records[1][$i]['rate'] ?></p>
                            <p class="unanswered"><?= _votes ?></p>
                        </div>
                        <?php
                        $parts = explode(',', $records[1][$i]['repliers']);
                        $a_num = count($parts) - 1;
                        if ($a_num != 0 && $records[1][$i]['correct_answer'] != 0) {
                            $newclass = 'answered-c';
                        }
                        if ($a_num != 0 && $records[1][$i]['correct_answer'] == 0) {
                            $newclass = 'answered-n';
                        }
                        if ($a_num == 0) {
                            $newclass = 'q-b-r-parts';
                        }
                        ?>
                        <div class="<?= $newclass ?>">
                            <p class="q-num">
                                <?= $a_num ?>
                            </p>
                            <p class="unanswered"><?= _answers ?></p>
                        </div>
                        <div class="q-b-r-parts">
                            <p class="q-num"><?= $records[1][$i]['views'] ?></p>
                            <p class="unanswered"><?= _views ?></p>
                        </div>
                    </div>
                    <div class="q-body-left<?=_css?>">
                        <div style="position: relative;">
                            <a class="q-title" href="/<?=_main_lang?>/questions/view/<?=topic_link($records[1][$i]['q_id'],$records[1][$i]['q_name'])?>"><?=$records[1][$i]['q_name']?></a>
                        </div>
                        <div style="position: relative;display: flex;">
                            <div style="position: relative;padding: 7px 0;">
                                <p>
                                    <?php
                                    for($j=1;$j<6;$j++){
                                        if($records[1][$i]['tag'.$j]!=''){ ?>
                                            <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($records[1][$i]['tag'.$j])?>" class="q-tag"><?=$records[1][$i]['tag'.$j]?></a>
                                        <?php }
                                        ?>
                                    <?php } ?>
                                </p>
                            </div>
                            <?php
                            if($a_num!=0){ ?>
                                <div class="writers-pos<?=_css?>">
                                    <?php
                                    $lasta=PageModel::get_last_answer_date($records[1][$i]['q_id']);
                                    $current = DAT();
                                    $two = strtotime($lasta['a_date']);
                                    $one = strtotime($current);
                                    $don = $one - $two;
                                    $x3 = time_calculation($don,$lasta['a_date']);
                                    ?>
                                    <div class="question-writer3<?=_css?>">
                                        answered <?=$x3?><a id="user-a-<?=$i?>" onmouseover="tooltip('a',<?=$lasta['replier']?>,<?=$i?>)" class="profile" href="/<?=_main_lang?>/page/profile/<?=profile_link($lasta['replier'],$lasta['user_name'])?>"> <?=$lasta['user_name']?></a>
                                    </div>
                                </div>
                            <?php }
                            else { ?>
                                <div class="writers-pos<?=_css?>">
                                    <?php
                                    $ifedited=PageModel::check_if_edited_q($records[1][$i]['q_id']);
                                    if($ifedited==null){
                                        $current = DAT();
                                        $two = strtotime($records[1][$i]['q_date']);
                                        $one = strtotime($current);
                                        $don = $one - $two;
                                        $x3 = time_calculation($don,$records[1][$i]['q_date']);
                                        ?>
                                        <div class="question-writer3<?=_css?>">
                                            asked <?=$x3?><a id="user-a-<?=$i?>" onmouseover="tooltip('a',<?=$records[1][$i]['asker']?>,<?=$i?>)" class="profile" href="/<?=_main_lang?>/page/profile/<?=profile_link($records[1][$i]['asker'],$records[1][$i]['user_name'])?>"> <?=$records[1][$i]['user_name']?></a>
                                        </div>
                                    <?php }
                                    else {
                                        $current = DAT();
                                        $two = strtotime($ifedited['e_date']);
                                        $one = strtotime($current);
                                        $don = $one - $two;
                                        $x3 = time_calculation($don,$ifedited['e_date']);
                                        ?>
                                        <div class="question-writer3<?=_css?>">
                                            modified <?=$x3?> <a id="user-a-<?=$i?>" onmouseover="tooltip('a',<?=$ifedited['editor_id']?>,<?=$i?>)" class="profile" href="/<?=_main_lang?>/page/profile/<?=profile_link($ifedited['editor_id'],$ifedited['user_name'])?>"> <?=$ifedited['user_name']?></a>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
        }
        ?>
    </div>
    <div id="u-switchable" class="none">
        <?php
        if($records[0]==null){ ?>
            <div class="s-not-found">
                No Users found
            </div>
        <?php }
        else {
        for ($t = 0; $t < count($records[0]); $t++) { ?>
            <div class="u-body<?= _css ?>">
                <div style="display: flex">
                    <img src="/uploads/<?= $records[0][$t]['user_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'" class="search-pic">
                    <div class="users-pos<?=_css?>">
                        <p><a class="profile" id="user-b-<?= $t ?>" onmouseover="tooltip('b',<?= $records[0][$t]['user_id'] ?>,<?= $t ?>)" href="/<?= _main_lang ?>/page/profile/<?= profile_link($records[0][$t]['user_id'], $records[0][$t]['user_name']) ?>"><?= $records[0][$t]['user_name'] ?></a></p>
                        <p title="reputation score"><?= $records[0][$t]['reputation'] ?></p>
                    </div>
                </div>
                <div class="writers-pos2<?=_css?>">
                    <p>
                        <span>member since </span>
                    <span><?php
                        $newtime = new DateTime($records[0][$t]['register_time'], new DateTimeZone("UTC"));
                        $newx = $newtime->setTimezone(new DateTimeZone("UTC"));
                        $newx = $newtime->format("M j,Y, g:i A");
                        echo $newx;
                        ?>
                    </span>
                    </p>
                </div>
                <p>
                    <?php
                    if ($records[0][$t]['about'] != '') { ?>
                        <?php
                        $string = substr($records[0][$t]['about'], 0, 190);
                        if (strlen($records[0][$t]['about']) > 190) {
                            echo $string . '<span class="p-dot">...</span>';
                        } else {
                            echo $records[0][$t]['about'];
                        }
                        ?>
                    <?php }
                    else { ?>
                        <span class="nth-about-usr"><?=_nothing_yet?></span>
                    <?php }
                    ?>
                </p>
            </div>
        <?php }
        }
        ?>
    </div>
</div>
<script>
    $(function(){
        $('#content-switchable').html($('#q-switchable').html());
    });
    function search_tabs(one,two){
        if($('#s_'+one+'_tab').hasClass('tab-close')){
            $('#s_'+one+'_tab').removeClass('tab-close');
            $('#s_'+one+'_tab').addClass('tab-open');
            $('#s_'+two+'_tab').removeClass('tab-open');
            $('#s_'+two+'_tab').addClass('tab-close');
            $('#content-switchable').html($('#'+one+'-switchable').html());
        }
    }
    function tooltip(type,uid,i){
        var cords=$('#user-'+type+'-'+i).offset();
        var xleft=cords.left;
        var xtop=cords.top;
        var relative=xtop-$(window).scrollTop();
        var dtop;
        var ttype;
        var hoo;
        if(relative<170){
            dtop=25;
            ttype='#custom-tooltip2';
            hoo='#custom-tooltip2:hover';
        }
        else{
            dtop=-176;
            ttype='#custom-tooltip1';
            hoo='#custom-tooltip1:hover';
        }
        $('#public-wait').fadeIn('normal').html("<img src='/image/waiting.gif' style='width:45px;height: 15px;'>");
        setTimeout(function(){
            $('#public-wait').fadeOut('normal');
            if($('#user-'+type+'-'+i+':hover').length>0){
                $.ajax('/<?=_main_lang?>/user/infox',{
                    type:'post',
                    dataType:'json',
                    data:{
                        iid:uid
                    },
                    success:function(data){
                        $(ttype).fadeIn('fast').html(data).css({left:xleft-10,top:xtop+dtop});
                    }
                });
            }
        },850);
        $('#user-'+type+'-'+i).on('mouseout',function(){
            setTimeout(function(){
                if($(hoo).length>0){

                }
                else {
                    if($('#user-'+type+'-'+i+':hover').length>0){

                    }
                    else {
                        $(ttype).fadeOut('slow');
                    }
                }
            },850);
        });
        $(ttype).hover(function(){},function(){
            setTimeout(function(){
                if($(hoo).length>0){

                }
                else {
                    $(ttype).fadeOut('slow');
                }
            },850);
        });
    }
</script>
