<div class="main-content-left">
    <div class="main-content-wrapper<?=_css?>">
        <span style="font-size: 15pt;"><?=_top_questions?></span>
        <div class="main-content-wrapper-inner<?=_css?>">
            <?php
            if($tab=='interesting'){
                $one='tab-open';
                $two='tab-close';
            }
            else {
                $one='tab-close';
                $two='tab-open';
            }
            ?>
            <a class="<?=$two?>" href="/<?=_main_lang?>/page/home/?tab=recent"><?=_recent?></a>
            <a class="<?=$one?>" href="/<?=_main_lang?>/page/home/?tab=interesting"><?=_interesting?></a>
        </div>
    </div>
    <?php
    $results=PageModel::get_questions($tab);
    for($i=0;$i<count($results);$i++){
        $parts=explode(',',$results[$i]['repliers']);
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
                    <p class="q-num"><?=$results[$i]['rate']?></p>
                    <p class="unanswered"><?=_votes?></p>
                </div>
                <?php
                if($a_num!=0&&$results[$i]['correct_answer']!=0){
                    $newclass='answered-c';
                }
                if($a_num!=0&&$results[$i]['correct_answer']==0){
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
                    <p class="q-num"><?=$results[$i]['views']?></p>
                    <p class="unanswered"><?=_views?></p>
                </div>
            </div>
            <div class="q-body-left<?=_css?>">
                <div style="position: relative;">
                    <a class="q-title" href="/<?=_main_lang?>/questions/view/<?=topic_link($results[$i]['q_id'],$results[$i]['q_name'])?>"><?=$results[$i]['q_name']?></a>
                </div>
                <div style="position: relative;display: flex;">
                    <div style="position: relative;padding: 7px 0;">
                        <p>
                            <?php
                            for($j=1;$j<6;$j++){
                                if($results[$i]['tag'.$j]!=''){ ?>
                                    <a href="/<?=_main_lang?>/questions/tag/<?=tag_link($results[$i]['tag'.$j])?>" class="q-tag"><?=$results[$i]['tag'.$j]?></a>
                                <?php }
                                ?>
                            <?php } ?>
                        </p>
                    </div>
                    <?php
                    if($a_num!=0){ ?>
                        <div class="writers-pos<?=_css?>">
                            <?php
                            $lasta=PageModel::get_last_answer_date($results[$i]['q_id']);
                            $current = DAT();
                            $two = strtotime($lasta['a_date']);
                            $one = strtotime($current);
                            $don = $one - $two;
                            $x3 = time_calculation($don,$lasta['a_date']);
                            ?>
                            <div class="question-writer3<?=_css?>">
                                <span><?=_answered.$x3?></span><a id="user-<?=$i?>" onmouseover="tooltip(<?=$lasta['replier']?>,<?=$i?>)" class="<?=$lasta['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($lasta['replier'],$lasta['user_name'])?>"> <?=$lasta['user_name']?></a>
                            </div>
                        </div>
                    <?php }
                    else { ?>
                        <div class="writers-pos<?=_css?>">
                            <?php
                            $ifedited=PageModel::check_if_edited_q($results[$i]['q_id']);
                            if($ifedited==null){
                                $current = DAT();
                                $two = strtotime($results[$i]['q_date']);
                                $one = strtotime($current);
                                $don = $one - $two;
                                $x3 = time_calculation($don,$results[$i]['q_date']);
                                ?>
                                <div class="question-writer3<?=_css?>">
                                    <span><?=_asked.$x3?></span><a id="user-<?=$i?>" onmouseover="tooltip(<?=$results[$i]['asker']?>,<?=$i?>)" class="<?=$results[$i]['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($results[$i]['asker'],$results[$i]['user_name'])?>"> <?=$results[$i]['user_name']?></a>
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
                                    <?=_modified.$x3?> <a id="user-<?=$i?>" onmouseover="tooltip(<?=$ifedited['editor_id']?>,<?=$i?>)" class="<?=$ifedited['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($ifedited['editor_id'],$ifedited['user_name'])?>"> <?=$ifedited['user_name']?></a>
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
    ?>
</div>
<div class="m-c-bottom">
    <span>Looking for more?browse the <a href="/<?=_main_lang?>/page/questions" class="q-title">complete list of questions!</a></span>
</div>
<script>
    $(function(){
        $('title').html('Ask Question!');
    });
    function tooltip(uid,i){
        var cords=$('#user-'+i).offset();
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
            if($('#user-'+i+':hover').length>0){
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
        $('#user-'+i).on('mouseout',function(){
            setTimeout(function(){
                if($(hoo).length>0){

                }
                else {
                    if($('#user-'+i+':hover').length>0){

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