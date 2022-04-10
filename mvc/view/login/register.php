<?php
if(isset($_SESSION['uid'])){
    header("Location:/"._main_lang);
}
?>
<div class="register-form">
    <p style="padding: 8px 0">
    <p>Display Name</p>
    <input class="register-input" type="text" placeholder="username" id="rname">
    <p class="errors" id="correct1">Illegal character</p>
    <p class="errors" id="correct4">Display name can not be empty</p>
    <p class="errors" id="correct8">Display name must contain more that 5 letters</p>
    <p class="errors" id="correct9">This name is being used,please choose another one</p>
    </p>
    <p style="padding: 8px 0">
    <p>Email(required, but never shown)</p>
    <input class="register-input" type="text" placeholder="Email" id="rmail">
    <p class="errors" id="correct2">Invalid Email</p>
    <p class="errors" id="correct5">Email can not be empty</p>
    <p class="errors" id="correct10">This email is being used,please choose another one</p>
    </p>
    <p style="padding: 8px 0">
    <p>Password</p>
    <input class="register-input" type="password" placeholder="password" id="rpass">
    <p class="errors" id="correct3">Password must contain more that 5 letters</p>
    <p class="errors" id="correct6">Password can not be empty</p>
    <p class="errors" id="correct7">Illegal character</p>
    </p>
    <p style="padding: 8px 0;">
        <span class="blue-button2" id="registerc">Sign Up</span>
    </p>
</div>

<script>
    $('#registerc').on('click',function(){
        $('.errors').fadeOut('fast');
        var username=$('#rname').val();
        var password=$('#rpass').val();
        var mail=$('#rmail').val();
        var ure = new RegExp("^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]*)*$");
        var pre = new RegExp("^[A-Za-z0-9]*(?:[A-Za-z0-9]*)*$");
        var mre = new RegExp("^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]+$");
        if(username.length!=0){
            if(username.length>5){
                if(ure.test(username)) {
                    if(password.length!=0){
                        if(password.length>5){
                            if(pre.test(password)){
                                if(mail.length!=0){
                                    if(mre.test(mail)){
                                        $.ajax('/<?=_main_lang?>/user/register',{
                                            type:'post',
                                            dataType:'json',
                                            data:{
                                                uname:username,
                                                pass:password,
                                                email:mail
                                            },
                                            success:function(data) {
                                                if (data.status == 'name') {
                                                    $('#correct9').fadeIn('normal');
                                                }
                                                if (data.status == 'mail') {
                                                    $('#correct10').fadeIn('normal');
                                                }
                                                if (data.status == 'blank') {
                                                    $('#public-info').html('All fields must be filled!').fadeIn('normal').delay(1000).fadeOut('normal');
                                                }
                                                if (data.status == 'length') {
                                                    $('#public-info').html('No field can be shorter than 5!').fadeIn('normal').delay(1000).fadeOut('normal');
                                                }
                                                if(data.status=='done') {
                                                    window.location='/<?=_main_lang?>/page/login';
                                                }
                                            }
                                        });
                                    }
                                    else {
                                        $('#correct2').fadeIn('normal');
                                    }
                                }
                                else {
                                    $('#correct5').fadeIn('normal');
                                }
                            }
                            else {
                                $('#correct7').fadeIn('normal');
                            }
                        }
                        else {
                            $('#correct3').fadeIn('normal');
                        }
                    }
                    else {
                        $('#correct6').fadeIn('normal');
                    }
                }
                else {
                    $('#correct1').fadeIn('normal');
                }
            }
            else {
                $('#correct8').fadeIn('normal');
            }
        }
        else {
            $('#correct4').fadeIn('normal');
        }
    });
</script>