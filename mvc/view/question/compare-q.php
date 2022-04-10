<div class="compare<?=_css?>">
    <div class="question-editors2<?=_css?>">
        <?php
        echo _asked;
        $current=DAT();
        $Date=$records[0]['q_date'];
        $two=strtotime($Date);
        $one=strtotime($current);
        $don=$one-$two;
        $x=time_calculation($don,$Date);
        echo $x.'<br>';
        ?>
        <div style="display: flex">
            <img class="mini-img" src="/uploads/<?=$records[0]['asker'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
            <div>
                <a id="user-0" onmouseover="tooltip_compare_q(<?=$records[0]['asker']?>,0)" class="<?=$records[0]['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($records[0]['asker'],$records[0]['user_name'])?>"><?=$records[0]['user_name']?></a>
                <p><span class="q-rep-num" title="reputation score"><?=$records[0]['reputation']?></span></p>
            </div>
        </div>
    </div>
    <div class="c-item">
        <div class="c-body<?=_css?>">
            <?=$records[0]['q_body'];?>
        </div>
    </div>
    <h2 class="revision<?=_css?>"><?=_revision?></h2>
    <?php
    for($i=0;$i<count($records[1]);$i++) {
        ?>
        <div style="position: relative;top:20px;">
            <div class="question-editors2<?=_css?>">
                <?php
                echo _edited;
                $current = DAT();
                $Date = $records[1][$i]['e_date'];
                $two = strtotime($Date);
                $one = strtotime($current);
                $don = $one - $two;
                $x = time_calculation($don, $Date);
                echo $x . '<br>';
                ?>
                <div style="display: flex">
                    <img class="mini-img" src="/uploads/<?=$records[1][$i]['editor_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
                    <div>
                        <a id="user-<?=$i+1?>" onmouseover="tooltip_compare_q(<?=$records[1][$i]['editor_id']?>,<?=$i+1?>)" class="<?=$records[1][$i]['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($records[1][$i]['editor_id'],$records[1][$i]['user_name'])?>"><?=$records[1][$i]['user_name']?></a>
                        <p><span class="q-rep-num" title="reputation score"><?=$records[1][$i]['reputation']?></span></p>
                    </div>
                </div>
            </div>
            <div class="c-item">
                <div class="c-body">
                    <?= $records[1][$i]['q_body']; ?>
                </div>
            </div>
        </div><br><br>
        <?php
    }
    ?>
</div>
<script>
    function tooltip_compare_q(uid,i){
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