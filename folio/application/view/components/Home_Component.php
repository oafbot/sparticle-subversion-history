<? self::scripts('home'); ?>
<? self::init()->config(); ?>
<?php
    $user  = self::init()->get_user();
    $title = self::init()->get_title();
    $id    = self::init()->get_id();
    $fav   = self::init()->get_fav();
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
            <img src=<? self::init()->get_feature(); ?> id="featured" />
            <img src=<? self::init()->get_reflection(); ?> id="flip"/>
        </div>
        <div id="title">
            <h1 id="image_name"><? echo (!empty($title) ? $title : "Untitled"); ?></h1>
            by <? self::link_to($user->username, '/user/'.$user->username, array('class'=>'user')); ?> 
            <nav id="tools" >
                <table>
                <tr class="webfont">
                    <td><a href="javascript:;" 
                        onclick="clickFlash(this);reloadImage();"
                        onmouseover="hilite('refresh')"
                        onmouseout="unhilite('refresh')"
                        id="refresh_icon">
                        &#42;</a></td>
                    <td><a href="javascript:;" 
                        onclick="clickFlash(this);"
                        onmouseover="hilite('fullscreen')"
                        onmouseout="unhilite('fullscreen')"
                        id="fullscreen_icon">
                        &#37;</a></td>
                    <td><a href="javascript:;" 
                        onclick="favorite(this,
                            '<? echo $id; ?>');
                            clickFlash(this);"
                        onmouseover="hilite('favorite')"
                        onmouseout="unhilite('favorite')"
                        id="favorite_icon">
                        <? echo $fav; ?></a></td>
                </tr>
                <tr class="label">
                    <td><a href="javascript:;"
                        onclick="clickFlash('#refresh_icon');reloadImage();"
                        onmouseover="hilite('refresh')"
                        onmouseout="unhilite('refresh')"                        
                        id="refresh">
                        Refresh</a></td>
                    <td><a href="javascript:;"
                        onclick="clickFlash('#fullscreen_icon');"
                        onmouseover="hilite('fullscreen')"
                        onmouseout="unhilite('fullscreen')"
                        id="fullscreen">
                        Full Screen</a></td>
                    <td><a href="javascript:;"
                        onclick="favorite(document.getElementById('favorite_icon'),
                            '<? echo $id; ?>');
                            clickFlash('#favorite_icon');"
                        onmouseover="hilite('favorite')"
                        onmouseout="unhilite('favorite')"
                        id="favorite">
                        Favorite</a></td>
                </tr>
                </table>    
            </nav>
        </div>

    </div>
    <div id="latest">
        <table>
            <tr>
            <? self::render_foreach('latest',FOLIO_Media::last(5)); ?>
            </tr>
        </table>
    </div>
</div>            
