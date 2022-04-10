<div class="users-list">
    <?php
    $users=PageModel::get_info_for_administration();
    for($i=0;$i<count($users);$i++){ ?>
        <div style="display: inline-block">
            <div class="user-info" id="u-i-<?=$users[$i]['user_id']?>">
                <div>
                    <a href="/<?=_main_lang?>/page/profile/<?=profile_link($users[$i]['user_id'],$users[$i]['user_name'])?>">
                        <img src="/uploads/<?=$users[$i]['user_id'].'.jpg'?>" style="height: 80px;width: 80px;">
                    </a>
                </div>
                <div>
                    <a class="profile" href="/<?=_main_lang?>/page/profile/<?=profile_link($users[$i]['user_id'],$users[$i]['user_name'])?>"><?=$users[$i]['user_name']?></a>
                    <p>
                        <span>level:<?=$users[$i]['class']?>(<?=$users[$i]['access']?>)</span>
                    </p>
                </div>
            </div>
        </div>

    <?php }
    ?>
</div>