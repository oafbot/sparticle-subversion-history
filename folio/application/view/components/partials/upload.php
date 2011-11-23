<? self::scripts('upload','jquery.form','jquery.MetaData','jquery.MultiFile','jquery.blockUI'); ?>
<div id="container">
<!--     <h1>Select files for upload:</h1> -->
    <form enctype="multipart/form-data" action="<? self::path_to('/upload'); ?>" method="POST">        
        <div class="controls">
            <input type="hidden" name="MAX_FILE_SIZE" value="<? echo MAX_FILE_SIZE; ?>" />
            <input name="upload[]" type="file" class="multi" id="upload" />        
            <div id="browse">
                <div id="browse_button" class="button blue medium">Select File</div>
            <!--<input type=text id="file_selected" />-->
            </div>
        </div>
        <div id="upload-list"></div>
        <div class="controls">
            <input type="submit" value="Upload Files" class="button blue medium"/>
        </div>
    </form>
</div>