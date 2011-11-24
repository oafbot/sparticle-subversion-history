<? self::scripts('user'); ?>
<div id="container">
    <form method=post action="<? self::path_to('/assets/delete'); ?>">
        <div class="controls dark upper">
            <? FOLIO_Media::render_pagination(8,'user',LAIKA_User::active()->id()); ?>
            <input type="submit" value="Delete" class="button blue medium" id="delete"/>            
        </div>
        <p>       
        <? foreach(self::init()->gallery as $key => $image ): ?>
            <? $id = FOLIO_Media::find('path',$image)->id(); ?>
            <div class=box>
                <img src=<? echo $image; ?> 
                    onclick="toggle_selection(<? echo $id ?>);" class="unselected" id=<? echo 'image'.$id ?> />
                <br />
                <input type="checkbox" value="<? echo $id; ?>" name="<? echo $key; ?>" 
                    onclick="toggle_selection(<? echo $id ?>)" id=<? echo 'checkbox'.$id; ?> /> 
                    <h3 id=<? echo 'name'.$id ?> >
                        <? if(FOLIO_Media::find('path',$image)->name() != NULL)
                               echo FOLIO_Media::find('path',$image)->name(); 
                           else
                               echo "Image #".$id; ?>
                    </h3>
            </div>
        <? endforeach; ?>
        <a href=<? self::path_to('/upload'); ?> >
            <div id=upload><span id=upload_label>Upload more</span></div>
        </a>
        </p>
    </form> 
    <div class="controls dark lower">
        <? FOLIO_Media::render_pagination(8,'user',LAIKA_User::active()->id()); ?>
    </div>
</div>  