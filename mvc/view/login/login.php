<?php
if(isset($_SESSION['uid'])){
    header("Location:/"._main_lang);
}
?>
<div class="register-form">
    <form action="/<?=_main_lang?>/user/login/<?=$records['url']?>" method="post">
        <p style="padding: 8px 0;">
        <p>Email</p>
        <input class="register-input" type="text" placeholder="Email" name="email">
        </p>
        <p style="padding: 8px 0;">
        <p>Password</p>
        <input class="register-input" type="password" placeholder="password" name="password">
        <p><input type="submit" class="blue-button2" value="Login"></p>
        </p>
    </form>
</div>