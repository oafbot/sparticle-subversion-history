<?php
   $media = self::init()->media;
   $user  = self::init()->user;
   $title = $media->name;
?>

<div id="container"> 
    <div class="controls dark upper">
    </div>
    <div id=content>
        <div id="image">
            <a href="javascript:;" onclick="enterFullScreen('<? self::init()->fullscreen(); ?>');" >
                <img src=<? echo LAIKA_Image::api_path( $media->path, 'constrain', '500' ); ?> />
            </a>
        </div>
        <div id="title">
            <h1 id="image_name"><? echo !empty($title) ? $title : "Untitled"; ?></h1>
            by <? self::link_to($user->username, '/user/'.$user->username, array('class'=>'user')); ?>
            <p id="description">
               <? echo $media->description; ?> 
            </p>
            <div id="details">
                <h2>Details:</h2>
                <? echo PICTURE_ICON; ?>&nbsp;
                <a href="<? echo $media->path; ?>" target="blank" >Original size: </a>
                <? echo LAIKA_Image::dimentions($media->path); ?>
                <br />
                <? echo CLOUD_ICON; ?>&nbsp;
                <? echo "Added: ".$media->created_to_date(); ?>
                <br />
                <? echo FAVORITE_ICON; ?>&nbsp;
                <? echo FOLIO_Favorite::count(array('item'=>$media->id))." Favorites" ; ?>
            </div>
        </div>
    </div>
</div>
<?php
    /* RENDER COMMENT MODULE */
    $param = array("parent_type"=>$media->type, "parent_id"=>$media->id);
    self::render('comments',$param); 
?>