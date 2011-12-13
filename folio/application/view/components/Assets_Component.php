<? self::scripts('user'); ?>
<? $user = self::init()->user; ?>

<div id="container">
    <form method=post action="<? self::path_to('/assets/action'); ?>">
        <div class="controls dark upper" >
            <div class="toolbar left">
            <? FOLIO_Media::render_pagination(8,'user',$user); ?>
            </div>
            <div class="toolbar center">
                Media Files
            </div>
            <div class="toolbar right">
                <input type="submit" name="action" value="Edit"   class="button black medium" />
                <input type="submit" name="action" value="Delete" class="button black medium" />
            </div>            
        </div>
        <div id="items">       
            <? self::paginate('FOLIO_Media',8,'user',$user,'assets'); ?>
            <a href=<? self::path_to('/upload'); ?> >
                <div id=upload><span id=upload_label>Upload more</span></div>
            </a>
        </div>
    </form> 
    <div class="controls dark lower">
        <? FOLIO_Media::render_pagination(8,'user',$user); ?>
    </div>
</div>  