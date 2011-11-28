<? $id = FOLIO_Media::find('path',$object->path)->id(); ?>                    
<div class=box>
    <? self::img($object->path,
        array('onclick'=>"toggle_selection($id)",'class'=>'unselected','id'=>'image'.$id)); ?>
    <br />                                        
    <input type="checkbox" value="<? echo $id; ?>" name="<? echo $label; ?>" 
        onclick="toggle_selection(<? echo $id ?>)" id=<? echo 'checkbox'.$id; ?> />         
    <h3 id=<? echo 'name'.$id ?> >
        <? 
        FOLIO_Media::find('path',$object->path)->name() != NULL ? 
        $name = FOLIO_Media::find('path',$object->path)->name() : 
        $name = "Image #".$id;
        echo $name; 
        ?>
    </h3>                
</div>