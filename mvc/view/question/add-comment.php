<div id="<?=$type?>-comment<?=$res?>" class="comment-total" style="display: none">
    <p class="comment-body">
        <?=$body?>
    </p>
    <p>
        <?php
        $current=DAT();
        $two=strtotime($date);
        $one=strtotime($current);
        $don=$one-$two;
        $x3=time_calculation($don,$date);
        echo $x3.'<br>';
        ?>
    </p>
    <a class="<?=$class?>" href="/<?=_main_lang?>/page/profile/<?=profile_link($uid,$name)?>"><?=$name?></a>
    <span class="profile" onclick="remove_comment('<?=$type?>',<?=$res?>,<?=$id?>)"><?=_delete?></span>
</div>