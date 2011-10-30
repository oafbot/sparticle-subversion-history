<?php  
if(!empty($_FILES) && isset($_FILES)):
    $file = new LAIKA_File();
    $upload = $file->upload($_FILES,MEDIA_DIRECTORY);
    if(isset($upload))
        self::redirect_to('/user/uploaded/');
endif;   
?>
<div id="container">
    <br />
    <form enctype="multipart/form-data" action="<? echo HTTP_ROOT.'/user/upload'; ?>" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="1073741824" />
        Choose a file to upload: <input name="upload" type="file" />
        <input type="submit" value="Upload File" class="button blue medium" style="position:relative;left:-95px;"/>
    </form>
</div>
<img src=<? if(isset($upload)) echo $upload; ?> />