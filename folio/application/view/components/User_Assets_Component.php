<? self::scripts('user'); ?>
<div id="container">
    <form method=post action="<? self::path_to('/user/assets'); ?>">
        <div id="controls">
            <input type="submit" value="submit" class="button blue medium"/>
        </div>        
        <? foreach(self::init()->gallery as $key => $image ): ?>
            <? $id = FOLIO_Media::find('path',$image)->id(); ?>
            <div class=box>
                <img src=<? echo $image; ?> 
                    onclick="toggle_selection(<? echo $id ?>);" class="unselected" id=<? echo 'image'.$id ?> />
                <br />
                <input type="checkbox" value="<? echo $id; ?>" 
                    onclick="toggle_selection(<? echo $id ?>)" id=<? echo 'checkbox'.$id; ?> /> 
                    <h3 id=<? echo 'name'.$id ?> >
                        <? if(FOLIO_Media::find('path',$image)->name() != NULL)
                               echo FOLIO_Media::find('path',$image)->name(); 
                           else
                               echo "Image #".$id; ?>
                    </h3>
            </div>
        <? endforeach; ?>
    </form>
</div>  