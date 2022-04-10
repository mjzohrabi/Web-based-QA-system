<script>tinymce.init({ selector: '#specialtxt',
        height: 200,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
            editor.on('click',function(){
                $('#how-to-format').fadeIn('fast');
                $('#how-to-ask').css('display','none');
                $('#how-to-tag').css('display','none');
            });
        } });
</script>
<div class="asking<?=_css?>">
    <div>
        <form action="/<?=_main_lang?>/questions/submit_question" method="post">
            <div style="position: relative;">
                <span><?=_title?></span>
                <input type="text" class="ask-input" name="ask_title" id="ask-title">
            </div>

            <div style="position: relative;top:30px;">
                <input id="specialtxt" name="ask_body">
            </div>

            <div style="position: relative;top:70px;">
                <span><?=_tags?></span>
                <input type="text" class="ask-input" name="ask_tags" id="ask-tags">
            </div>
            <div style="position: relative;top:100px;">
                <button type="submit" class="blue-button2"><?=_Post_Your_Question?></button>
            </div>
        </form>
    </div>
    <div class="asking-tips<?=_css?>">
        <h3>
            <?=_question_will_not?>
        </h3>
        <div id="how-to-ask" class="new-user-guide">
            <h4><?=_how_to_ask?></h4>
            <br>
            <b><?=_is_your_question?></b>
            <br><br>
            <p><?=_we_prefer?></p>
            <br><br>
            <p><?=_provide_share?></p>
        </div>
        <div id="how-to-format" class="new-user-guide">
            <h4><?=_how_to_format?></h4>
            <br>
            <p><?=_put_return?></p>
            <br>
            <p><?=_italic?></p>
            <br>
            <p><?=_make_link?></p>
        </div>
        <div id="how-to-tag" class="new-user-guide">
            <h4><?=_how_to_tag?></h4>
            <br>
            <b><?=_a_tag_is?></b>
            <br><br>
            <p><?=_favor_tag?></p>
            <br>
            <p><?=_abbreviations?></p>
            <br>
            <p><?=_syno?></p>
            <br>
            <p><?=_combine?></p>
            <br>
            <p><?=_max_tag?></p>
            <br>
            <p><?=_tag_char?></p>
            <br>
            <p><?=_delimit_tag?></p>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#how-to-ask').css('display','inline-block');
    });
    $('#ask-title').on('click',function(){
        $('#how-to-ask').fadeIn('fast');
        $('#how-to-format').css('display','none');
        $('#how-to-tag').css('display','none');
    });
    $('#ask-tags').on('click',function(){
        $('#how-to-tag').fadeIn('fast');
        $('#how-to-ask').css('display','none');
        $('#how-to-format').css('display','none');
    });

</script>