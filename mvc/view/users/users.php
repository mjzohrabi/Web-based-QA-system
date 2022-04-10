<div class="users-bar<?=_css?>">
    <div class="users-icon<?=_css?>"><span class="fa fa-users fa-3x"> <?=_users_list?></span></div>
    <?php
    for ($t = 0; $t < count($records); $t++) { ?>
        <div class="u-body<?= _css ?>">
            <div style="display: flex">
                <img src="/uploads/<?= $records[$t]['user_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'" class="search-pic">
                <div class="users-pos<?=_css?>">
                    <p><a class="profile" id="user-b-<?= $t ?>" onmouseover="tooltip('b',<?= $records[$t]['user_id'] ?>,<?= $t ?>)" href="/<?= _main_lang ?>/page/profile/<?= profile_link($records[$t]['user_id'], $records[$t]['user_name']) ?>"><?= $records[$t]['user_name'] ?></a></p>
                    <p title="reputation score"><?= $records[$t]['reputation'] ?></p>
                </div>
            </div>
            <div class="writers-pos2<?=_css?>">
                <p>
                    <span>member since </span>
                    <span><?php
                        $newtime = new DateTime($records[$t]['register_time'], new DateTimeZone("UTC"));
                        $newx = $newtime->setTimezone(new DateTimeZone("UTC"));
                        $newx = $newtime->format("M j,Y, g:i A");
                        echo $newx;
                        ?>
                    </span>
                </p>
            </div>
            <p>
                <?php
                if ($records[$t]['about'] != '') { ?>
                    <?php
                    $string = substr($records[$t]['about'], 0, 190);
                    if (strlen($records[$t]['about']) > 190) {
                        echo $string . '<span class="p-dot">...</span>';
                    } else {
                        echo $records[$t]['about'];
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
    ?>
</div>
<script>
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
