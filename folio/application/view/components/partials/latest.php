<!-- <img src="<? echo $object->path() ?>" class="carousel" /> -->
<td>
<a href="<? self::init()->get_permalink($object->path); ?>" class="permalink" >
<? self::img( LAIKA_Image::api_path($object->path,'auto', 150),
    array('onclick'=>"",'class'=>'carousel', 'title'=>$object->name)); ?>
</a>
</td>