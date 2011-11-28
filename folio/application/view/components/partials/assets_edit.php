<?php 
    $m = FOLIO_Media::find('id',$object); 
    $m->privacy == 1 ? $privacy = 'public' : $privacy = 'private'; 
    $privacy == 'public' ? $option = 'private' : $option  = 'public'; 
?>
<tr>
<td>
    <a href=<? echo $m->path; ?> target="blank">
        <img src=<? echo $m->path; ?> />
    </a>
</td>
<td>
    <input type="text" name="<? echo 'name-'.$m->id; ?>" value="<? echo $m->name; ?>" placeholder="Title" class="title" />
    <select name="<? echo 'privacy-'.$m->id; ?>">
        <option  value="<? echo $m->privacy; ?>" ><? echo $privacy; ?></option>
        <option  value="<? echo (int)~$m->privacy; ?>" ><? echo $option; ?></option>
    </select>
    <br />
    <textarea name="<? echo 'description-'.$m->id; ?>" rows=10 cols=20 class="description" placeholder="Description" ><? echo $m->description; ?></textarea>
</td>
</tr>