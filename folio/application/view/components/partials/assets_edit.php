<?php 
    $m = FOLIO_Media::find('id',$object); 
    $m->privacy == 1 ? $privacy = UNLOCKED_ICON.' public' : $privacy = LOCKED_ICON.' private'; 
    $privacy == UNLOCKED_ICON.' public' ? $option = LOCKED_ICON.' private' : $option  = UNLOCKED_ICON.' public'; 
?>
<tr>
<td>
    <a href=<? echo $m->path; ?> target="blank">
        <img src=<? echo LAIKA_Image::api_path($m->path,'landscape', 300); ?> />
    </a>
</td>
<td class="input-combo">
    <input type="text" name="<? echo 'name-'.$m->id; ?>" value="<? echo $m->name; ?>" placeholder="Title" class="title" />
    <? if($m->privacy): ?>
        <button class="button gray"  type="button" id="<? echo 'privacy-'.$m->id; ?>" href="javascript:;"><? echo $privacy; ?>
    <? else: ?>
        <button class="button black" type="button" id="<? echo 'privacy-'.$m->id; ?>" href="javascript:;"><? echo $privacy; ?>
    <? endif;?> 
    </button>   
    <input type="hidden" value="<? echo (int)~$m->privacy; ?>" name="<? echo 'privacy-'.$m->id; ?>"/>

    <textarea name="<? echo 'description-'.$m->id; ?>" rows=10 cols=20 class="description" placeholder="Description" ><? echo $m->description; ?></textarea>
</td>
</tr>