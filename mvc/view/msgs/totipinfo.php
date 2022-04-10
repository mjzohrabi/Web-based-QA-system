<div class="hover-info<?=_css?>">
    <div class="hover-name-bar">
        <p>
            <a class="<?=$record['class']?> hover-name<?=_css?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($record['user_id'],$record['user_name'])?>"><?=$record['user_name']?></a>
        </p>
    </div>
    <div style="display: flex">
        <div class="hover-left<?=_css?>">
            <img class="hover-img" src="/uploads/<?=$record['user_id'].'.jpg'?>" onerror="src='/image/empty-profile.png'">
            <p class="hover-rep">
                <span ><?=$record['reputation']?></span>
            </p>
        </div>
        <div>&nbsp;&nbsp;&nbsp;</div>
        <div class="hover-right<?=_css?>">
            <p>
                <span><?=_group?></span>
                <span class="<?=$record['class']?>"><?=$record['class']?></span>
            </p>
            <p>
                <span><?=_member_since?></span>
                <span><?php
                    $newtime=new DateTime($record['register_time'],new DateTimeZone("UTC"));
                    $newx=$newtime->setTimezone(new DateTimeZone("UTC"));
                    $newx=$newtime->format("M j,Y, g:i A");
                    echo $newx;
                    ?>
                </span>
            </p>
            <p>
                <span><?=_profile_views?></span>
                <span><?=$record['views']?></span>
            </p>
            <p>
                <span><?=_total_answers?></span>
                <span><?=count(explode(',',$record['answered_q']))-1?></span>
            </p>
            <p>
                <span><?=_total_q?></span>
                <span>
                    <?php
                    $num=PageModel::get__user_questions_count($record['user_id']);
                    echo $num;
                    ?>
                </span>
            </p>
            <p>
                <span><?=_favourite_tags?></span>
                <span>
                    <?php
                    $tags=explode(',',$record['fav_tags']);
                    if(count($tags)>5){
                        $num=5;
                    }
                    else {
                        $num=count($tags)-1;
                    }
                    if(count($tags)==1){
                        echo 'nothing yet';
                    }
                    else {
                        for($j=0;$j<$num;$j++){
                            if($tags[$j]!=''){ ?>
                                <a href="/<?=_main_lang?>/questions/tag/<?=$tags[$j]?>" class="tool-tip-tag"><?=$tags[$j]?></a>
                            <?php
                            if($j!=$num-1){
                                echo '<span>,</span>';
                            }
                            }
                            ?>
                        <?php }
                        if($num==5){
                            echo '<span> , ...</span>';
                        }
                    }
                    ?>
                </span>
            </p>
        </div>
    </div>
</div>