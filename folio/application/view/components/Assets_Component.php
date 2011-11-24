<? self::scripts('user'); ?>
<div id="container">
    <form method=post action="<? self::path_to('/assets/delete'); ?>">
        <div class="controls dark upper">
            <? FOLIO_Media::render_pagination(8,'user',LAIKA_User::active()->id()); ?>
            <input type="submit" value="Delete" class="button blue medium" id="delete"/>            
        </div>
        <div id="items">       

            <? foreach(self::init()->gallery as $key => $image ): ?>
                <? $id = FOLIO_Media::find('path',$image)->id(); ?>                
                
                <div class=box>
                    <? self::img($image, array('onclick'=>"toggle_selection($id)",'class'=>'unselected','id'=>'image'.$id)); ?>
                    <br />                                        
                    <input type="checkbox" value="<? echo $id; ?>" name="<? echo $key; ?>" 
                        onclick="toggle_selection(<? echo $id ?>)" id=<? echo 'checkbox'.$id; ?> /> 
                        
                        <h3 id=<? echo 'name'.$id ?> >
                        <? 
                            FOLIO_Media::find('path',$image)->name() != NULL ? 
                            $name = FOLIO_Media::find('path',$image)->name() : 
                            $name = "Image #".$id;
                            echo $name; 
                        ?>
                        </h3>                
                </div>
            <? endforeach; ?>

            <a href=<? self::path_to('/upload'); ?> >
                <div id=upload><span id=upload_label>Upload more</span></div>
            </a>
        </div>
    </form> 
    <div class="controls dark lower">
        <? FOLIO_Media::render_pagination(8,'user',LAIKA_User::active()->id()); ?>
    </div>
</div>  