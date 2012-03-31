<? FirePHP::getInstance(true)->log($object, 'Trace'); ?>
<a href="<? echo HTTP_ROOT.'/content?id='.$object->id; ?>">
    <img src="<? echo LAIKA_Image::api_path($object->path, 'auto', '300' ); ?>" class="small_image"/>
</a>
<br />
