<? $uid = md5(uniqid(mt_rand())); ?>
<? self::scripts('upload','jquery.form','jquery.MetaData','jquery.MultiFile','jquery.blockUI','jquery-ui/js/jquery-ui','upload_progress'); ?>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>-->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/start/jquery-ui.css" rel="stylesheet" />

<div id="container">
    <form enctype="multipart/form-data" action="<? self::path_to('/upload'); ?>" method="POST" id="upload-form" >        
        <input type="hidden" name="UPLOAD_IDENTIFIER" value="<? echo $uid; ?>" id="uid" />
        <input type="hidden" name="MAX_FILE_SIZE"     value="<? echo MAX_FILE_SIZE; ?>" />
        <div class="controls">
            <input name="upload[]" type="file" class="multi" id="upload" />        
            <div id="browse">
                <div id="browse_button" class="button blue medium">Select File</div>
            <!--<input type=text id="file_selected" />-->
            </div>
        </div>
        <div id="upload-list"></div>
        <div id="progress-bar"></div>
        <iframe id="upload-frame" name="upload-frame"></iframe>
        <div class="controls">
            <input type="submit" value="Upload Files" class="button blue medium"/>
        </div>
    </form>
</div>