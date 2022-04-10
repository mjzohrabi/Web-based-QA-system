<?php
$chats=PageModel::get_chats();
for($i=0;$i<count($chats);$i++){ ?>
    <div class="chat-main" id="c-row<?=$chats[$i]['ch_id']?>">
        <div class="mention" onclick="mention('<?=$chats[$i]['user_name']?>')">@</div>
        <div class="chat-i-div"><img class="chat-img" src="/uploads/<?=$chats[$i]['ch_userid'].'.jpg'?>" onerror="src='/image/empty-profile.png'"></div>
        <div class="chat-name"><a id="user-<?=$i?>" onmouseover="chat_tooltip(<?=$chats[$i]['ch_userid']?>,<?=$i?>)" class="<?=$chats[$i]['class']?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($chats[$i]['ch_userid'],$chats[$i]['user_name'])?>"><?=$chats[$i]['user_name']?></a> : </div>
        <div class="chat-body"><?=$chats[$i]['ch_body']?></div>
        <div class="chat-date"><?php
            $current = DAT();
            $two = strtotime($chats[$i]['ch_date']);
            $one = strtotime($current);
            $don = $one - $two;
            $x3 = time_calculation($don,$chats[$i]['ch_date']);
            echo $x3;
            ?>
        </div>
        <?php
        if(isset($_SESSION['uid'])&&$_SESSION['uid']==$chats[$i]['ch_userid']){ ?>
            <div style="width: 20px;">
                <i class="fa fa-edit" style="cursor: pointer;color: dodgerblue" onclick="edit('<?=$chats[$i]['ch_id']?>')"></i>
            </div>
            <?php
            if($chats[$i]['access']>=80){ ?>
                <div style="width: 20px;">
                    <i class="fa fa-close" style="cursor: pointer;color: red" onclick="remove('<?=$chats[$i]['ch_id']?>')"></i>
                </div>
            <?php }
            ?>
        <?php }
        ?>
    </div>
<?php }
?>