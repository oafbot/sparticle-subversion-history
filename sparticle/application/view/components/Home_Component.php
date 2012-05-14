<? self::init()->config(); ?>
<?php
    $user  = self::init()->get_user();
    $title = self::init()->get_title();
    $offset = 0;
    $limit  = 5;
    $_SESSION['pagination'] = 1;
?>
<div id="container">
    <div id="feature">
<!--
        <div id="logo">
            <img src="<? echo IMG_DIRECTORY."/logo_white.svg"; ?>" type="image/svg+xml" id="svg" />
            <h1 class="pacifico logo"><? echo APPLICATION_TITLE; ?></h1>
        </div>
-->
        <div id="image">
            <div class="webfont loader" id="loader"></div>
            <a href="<? self::init()->get_permalink(self::init()->path); ?>" id="permalink">
                <img src=<? self::init()->get_feature(); ?> id="featured" />
            </a>
            <img src=<? self::init()->get_reflection(); ?> id="flip"/>
        </div>
        <div id="title">
            <h1 id="image_name"><? echo (!empty($title) ? $title : "Untitled"); ?></h1>
            by <? self::link_to($user->username, '/user/'.$user->username, array('class'=>'user')); ?> 
            <nav id="tools" >
                <? self::render('home_tool_panel'); ?> 
            </nav>
        </div>
    </div>
    <div id="latest_title">
        <img src="<? echo IMG_DIRECTORY."/logo_white.svg"; ?>" type="image/svg+xml" id="svg" />
        <h1 >Latest contributions</h1>
    </div>
    <div id="latest">
        <div id="back"><a href="javascript:;"><? echo BACK_ICON; ?></a></div>
        <table id="set-1" class="current_set">
            <tr>
                <? //self::render_foreach('latest',FOLIO_Media::last($limit)); ?>
                <? self::paginate('FOLIO_Media',$limit,array(0),'latest',array('DESC'=>'created')); ?>
            </tr>
        </table>
        <table id="set-2" class="next_set" >
            <tr>
            <? self::init()->next_set($limit); ?>
            </tr>
        </table>
        <div id="next"><a href="javascript:;"><? echo FORWARD_ICON; ?></a></div>
    </div>
</div>
<? 
//$collection = FOLIO_Media::collection(FOLIO_Media::find_with_offset_order_by(array(0),$offset,$limit,array('DESC'=>$limit)));
//self::render_foreach('latest',$collection); 
?>

            
