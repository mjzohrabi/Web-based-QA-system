<div class="chat-header">
    <span>Chatbox</span>
</div>
<div class="chat-out">
    <div class="chat-header2">
        <span class="blink">Please Use Embed Video Links for Youtube Videos</span>
    </div>
    <div class="chat-in" id="chat-box">
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
    </div>
    <?php
    if(isset($_SESSION['uid'])){ ?>
        <div class="chat-input-bar">
            <input type="text" class="chat-input" id="chat-input-text">
            <span id="send-chat" class="chat-btn">Send</span>
            <span onclick="save_changes()" id="edit-chat" class="chat-btn" style="display: none">Save</span>
            <span onclick="chats()" class="chat-btn">Refresh</span>
            <span onclick="cancel_edit()" id="cancel-edit" class="chat-btn" style="display: none">Cancel</span>
            <span style="display: none" id="edit_key"></span>
        </div>
        <div class="chat-input-bar2">
            <span onclick="add_image()" class="chat-btn2">Image</span>
            <span onclick="add_video()" class="chat-btn2">Video</span>
            <span onclick="add_url()" class="chat-btn2">Url</span>
            <span onclick="add_color()" class="chat-btn2">Color</span>
            <span onclick="add_code()" class="chat-btn2">Code</span>
            <span onclick="add_italic()" class="chat-btn2">Italic</span>
            <span onclick="add_strike()" class="chat-btn2">Strikethrough</span>
            <span onclick="add_underline()" class="chat-btn2">Underlined</span>
            <span onclick="add_blink()" class="chat-btn2">Blink</span>
            <span onclick="add_bold()" class="chat-btn2">Bold</span>
            <span onclick="add_bolder()" class="chat-btn2">Bolder</span>
        </div>
    <?php }
    else { ?>
        <div class="chat-input-bar" style="color: white">
            You can not chat unless you are logged in.Have an account?<a class="profile2" href="/<?=_main_lang?>/page/login/?rd=chat">Login</a>
            <span onclick="chats()" class="chat-btn">Refresh</span>
        </div>
    <?php }
    ?>
</div>
<script>
    $(function(){
        rainbow();
    });
    setInterval(function(){rainbow();},11000);
    function rainbow(){
        var num=new Array('#1e1e1e','red','#1e1e1e','salmon','#1e1e1e','gold','#1e1e1e','lime','#1e1e1e','pink','#1e1e1e','orange','#1e1e1e','chartreuse','#1e1e1e','aqua','#1e1e1e','white','#1e1e1e','firebrick','#1e1e1e','peru');
        var i=0;
        xloop(num,i);
    }
    function xloop(num,i){
        setTimeout(function(){
            $('.blink').css('color',num[i]);
            i++;
            if(i<22){
                xloop(num,i);
            }
        },500);
    }
    function spoiler(key){
        //alert(key);
        $('#spoiler-div-'+key).toggleClass('none');
    }
    function add_image(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [img][/img]');
    }
    function add_video(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [vid][/vid]');
    }
    function add_color(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [color=][/color]');
    }
    function add_blink(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [blink][/blink]');
    }
    function add_url(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [url][/url]');
    }
    function add_underline(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [u][/u]');
    }
    function add_code(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [code][/code]');
    }
    function add_italic(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [i][/i]');
    }
    function add_strike(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [s][/s]');
    }
    function add_bold(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [b][/b]');
    }
    function add_bolder(){
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+' [B][/B]');
    }
    function save_changes(){
        var cid=$('#edit_key').html();
        var newbody=$('#chat-input-text').val();
        $.ajax('/<?=_main_lang?>/chat/edit_chat',{
            type:'post',
            dataType:'json',
            data:{
                chat_id:cid,
                body:newbody
            },
            success:function(data){
                if(data){
                    chats();
                    $('#edit-chat').css('display','none');
                    $('.fa-close').fadeIn('normal');
                    $('#cancel-edit').css('display','none');
                    $('#send-chat').css('display','inline-block');
                    $('#chat-input-text').val('');
                }
            }
        });
    }
    $("#chat-input-text").keyup(function(event){
        if(event.keyCode == 13){
            if($('#send-chat:visible').length!=0){
                $("#send-chat").click();
            }
            else {
                $("#edit-chat").click();
            }
        }
    });
    function cancel_edit(){
        $('#edit-chat').css('display','none');
        $('.fa-close').fadeIn('normal');
        $('#cancel-edit').css('display','none');
        $('#send-chat').css('display','inline-block');
        $('#chat-input-text').val('');
    }
    function mention(user_name){
        var string='@['+user_name+']';
        var current=$('#chat-input-text').val();
        $('#chat-input-text').val(current+string);
    }
    function edit(cid){
        $('.fa-close').fadeOut('normal');
        $.ajax('/<?=_main_lang?>/chat/get_chat_to_edit',{
            type:'post',
            dataType:'json',
            data:{
                chat_id:cid
            },
            success:function(data){
                $('#chat-input-text').val(data);
                $('#edit_key').html(cid);
                $('#send-chat').css('display','none');
                $('#edit-chat').css('display','inline-block');
                $('#cancel-edit').css('display','inline-block');
            }
        });
    }
    function remove(cid){
        $.ajax('/<?=_main_lang?>/chat/remove_chat',{
            type:'post',
            dataType:'json',
            data:{
                chat_id:cid
            },
            success:function(data){
                if(data){
                    $('#c-row'+cid).fadeOut('normal');
                }
            }
        });
    }
    $('#send-chat').on('click',function(){
        var msg=$('#chat-input-text').val();
        $.ajax('/<?=_main_lang?>/chat/submit_chat',{
            type:'post',
            dataType:'json',
            data:{
                body:msg
            },
            success:function(data){
                $('#chat-input-text').val('');
                if(data){
                    chats();
                }
            }
        });
    });
    setInterval(function(){chats()},20000);
    function chats(){
        $('#public-wait').fadeIn('normal').html("<img src='/image/waiting.gif' style='width:45px;height: 15px;'>").delay(400).fadeOut('normal');
        $.ajax('/<?=_main_lang?>/chat/chats',{
            type:'post',
            dataType:'json',
            success:function(data){
                $('#chat-box').html(data);
            }
        });
    }
    function chat_tooltip(uid,i){
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