<script>tinymce.init({ selector: '#editbox2',
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
        } });
</script>
<?php
$url=geturl();
$urlparts=explode('/',$url);
?>
<div style="position: relative;left:10%;width: 1200px;">
    <form class="edit-form<?=_css?>" action="/<?=_main_lang?>/questions/submit_edit_a/<?=$records['a_id']?>/<?=$urlparts[count($urlparts)-1]?>" method="post">
        <input id="editbox2" name="edited">
        <button type="submit" class="blue-button2"><?=_save_changes?></button>
    </form>
</div>
<script>
    $(function(){
        setTimeout(function(){
            tinyMCE.get('editbox2').setContent('<?=$records['a_body']?>');
        },500);
    });
</script>