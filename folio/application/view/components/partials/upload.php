<? self::scripts('upload','jquery.form','jquery.MetaData','jquery.MultiFile','jquery.blockUI'); ?>
<div id="container" style="background-color:#eee;">
<!--     <h1>Select files for upload:</h1> -->
    <form enctype="multipart/form-data" action="<? self::path_to('/upload'); ?>" method="POST">        
        <input type="hidden" name="MAX_FILE_SIZE" value="<? echo MAX_FILE_SIZE; ?>" />
        <input name="upload[]" type="file" class="multi" id="upload" />
        <div id="browse">
            <div id="browse_button" class="button blue medium">Select File</div>
            <!--<input type=text id="file_selected" />-->
        </div>
        <div id="upload-list"></div>
        <br />
        <input type="submit" value="Upload Files" class="button blue medium"/>
    </form>
</div>