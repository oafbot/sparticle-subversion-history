<!-- <img src="<? echo $object->path() ?>" class="carousel" /> -->
<td>
<? self::img( LAIKA_Image::api_path($object->path,'auto', 150),
    array('onclick'=>"",'class'=>'carousel')); ?>
</td>