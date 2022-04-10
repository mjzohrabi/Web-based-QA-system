<div class="main-content-left">
    <div class="main-content-wrapper<?=_css?>">
        <span style="font-size: 15pt;"><?=_all_questions?></span>
    </div>
    <?php
    $results=PageModel::get_all_questions($records['start'],$records['count']);
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
        <div class="q-body<?=_css?>" style="background-color: <?=$bckgrnd?>">
            <div style="position: relative;left: 8px;">
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
                <div style="position: relative;color: #848d95;height: 70px;">
                    <?php
                    $string=substr($results[$i]['q_body'],0,190);
                    if(strlen($results[$i]['q_body'])>190){
                        echo $string.'<span class="p-dot">...</span>';
                    }
                    else {
                        echo $results[$i]['q_body'];
                    }
                    ?>
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
                            <div class="question-writer2-2<?=_css?>" style="background-color: <?=$bckgrnd?>">
                                <?php
                                echo _answered;
                                $lasta=PageModel::get_last_answer_date($results[$i]['q_id']);
                                $current = DAT();
                                $two = strtotime($lasta['a_date']);
                                $one = strtotime($current);
                                $don = $one - $two;
                                $x3 = time_calculation($don,$lasta['a_date']);
                                echo $x3.'<br>';
                                ?>
                                <div style="display: flex">
                                    <img class="mini-img" src="/uploads/<?=$lasta['replier'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                                    <div>
                                        <a id="user-<?=$i?>" onmouseover="tooltip_tagged(<?=$lasta['replier']?>,<?=$i?>)" class="<?=$lasta['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($lasta['replier'],$lasta['user_name'])?>"> <?=$lasta['user_name']?></a>
                                        <p><span class="q-rep-num" title="reputation score"><?=$lasta['reputation']?></span></p>
                                    </div>
                                </div>
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
                                <div class="question-writer2-2<?=_css?>">
                                    <?=_asked.$x3?>
                                    <div style="display: flex">
                                        <img class="mini-img" src="/uploads/<?=$results[$i]['asker'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                                        <div>
                                            <a id="user-<?=$i?>" onmouseover="tooltip_tagged(<?=$results[$i]['asker']?>,<?=$i?>)" class="<?=$results[$i]['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($results[$i]['asker'],$results[$i]['user_name'])?>"> <?=$results[$i]['user_name']?></a>
                                            <p><span class="q-rep-num" title="reputation score"><?=$results[$i]['reputation']?></span></p>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            else {
                                $current = DAT();
                                $two = strtotime($ifedited['e_date']);
                                $one = strtotime($current);
                                $don = $one - $two;
                                $x3 = time_calculation($don,$ifedited['e_date']);
                                ?>
                                <div class="question-writer2-2<?=_css?>">
                                    <?=_modified.$x3?>
                                    <div style="display: flex">
                                        <img class="mini-img" src="/uploads/<?=$ifedited['editor_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                                        <div>
                                            <a id="user-<?=$i?>" onmouseover="tooltip_tagged(<?=$ifedited['editor_id']?>,<?=$i?>)" class="<?=$ifedited['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($ifedited['editor_id'],$ifedited['user_name'])?>"> <?=$ifedited['user_name']?></a>
                                            <p><span class="q-rep-num" title="reputation score"><?=$ifedited['reputation']?></span></p>
                                        </div>
                                    </div>
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
    <div class="pagination<?=_css?>">
        <?php
        //echo $records['index'].'<br>'.$records['index']+3;exit;
        if($records['index']>5){
            if($records['index']==1){ ?>
                <span class="pagination-btn-current">1</span>
            <?php }
            else { ?>
                <a href="/<?=_main_lang?>/page/questions" class="pagination-btn">1</a>
            <?php }
            echo '<span class="p-dot">...</span>';
            for($i=$records['index']-3;$i<=$records['index']+3;$i++){

                if($records['index']==$i){ ?>
                    <span class="pagination-btn-current"><?=$i?></span>
                <?php }
                else { ?>
                    <a href="/<?=_main_lang?>/page/questions/<?=$i?>" class="pagination-btn"><?=$i?></a>
                <?php }
                if($i==$records['ceil']){
                    break;
                }
            }
            if($records['index']+3<$records['ceil']){
                if($records['index']+4!=$records['ceil']){
                    echo '<span class="p-dot">...</span>';
                }
                ?>
                <a href="/<?=_main_lang?>/page/questions/<?=$records['ceil']?>" class="pagination-btn"><?=$records['ceil']?></a>
            <?php }
        }
        else {
            if($records['ceil']>8){
                for($i=1;$i<8;$i++){
                    if($records['index']==$i){ ?>
                        <span class="pagination-btn-current"><?=$i?></span>
                    <?php }
                    else { ?>
                        <a href="/<?=_main_lang?>/page/questions/<?=$i?>" class="pagination-btn"><?=$i?></a>
                    <?php }
                }
                echo '<span class="p-dot">...</span>'; ?>
                <a href="/<?=_main_lang?>/page/questions/<?=$records['ceil']?>" class="pagination-btn"><?=$records['ceil']?></a>
            <?php }
            else {
                for($i=1;$i<=$records['ceil'];$i++){
                    if($records['index']==$i){ ?>
                        <span class="pagination-btn-current"><?=$i?></span>
                    <?php }
                    else { ?>
                        <a href="/<?=_main_lang?>/page/questions/<?=$i?>" class="pagination-btn"><?=$i?></a>
                    <?php }
                }
            }
        }
        ?>
    </div>
</div>
<script>
    $(function(){
        $('title').html('Newest Questions');
    })
    function tooltip_tagged(uid,i){
        var cords=$('#user-'+i).offset();
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
            if($('#user-'+i+':hover').length>0){
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
        $('#user-'+i).on('mouseout',function(){
            setTimeout(function(){
                if($('#custom-tooltip'+ttype+':hover').length>0){

                }
                else {
                    if($('#user-'+i+':hover').length>0){

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
</script>