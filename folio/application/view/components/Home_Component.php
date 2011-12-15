<? self::scripts('home'); ?>
<? self::init()->config(); ?>
<?php
    $user  = self::init()->get_user();
    $title = self::init()->get_title();
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
            <img src=<? self::init()->get_feature(); ?> id="featured" />
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
<!--
    <div id="latest">
        <table>
            <tr>
            <? //self::render_foreach('latest',FOLIO_Media::last(5)); ?>
            </tr>
        </table>
    </div>
-->
</div>            
