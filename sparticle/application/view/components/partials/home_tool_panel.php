<?php 
    $id = self::init()->get_id(); 
    $fav = self::init()->get_fav();
?>

<? if(LAIKA_Access::is_logged_in()): ?>
<table>
<tr class="webfont">
    <td><a href="javascript:;" 
        onclick="clickFlash(this);reloadImage(true);"
        onmouseover="hilite('refresh')"
        onmouseout="unhilite('refresh')"
        id="refresh_icon">
        &#42;</a></td>
    <td><a href="javascript:;" 
        onclick="goFullScreen('<? self::init()->fullscreen(); ?>');"
        onmouseover="hilite('fullscr')"
        onmouseout="unhilite('fullscr')"
        id="fullscr_icon">
        &#37;</a></td>
    <td><a href="javascript:;" 
        onclick="favorite_this(this,
            '<? echo $id; ?>');
            clickFlash(this);"
        onmouseover="hilite('favorite')"
        onmouseout="unhilite('favorite')"
        id="favorite_icon"><? echo $fav; ?></a></td>
</tr>
<tr class="label">
    <td><a href="javascript:;"
        onclick="clickFlash('#refresh_icon');reloadImage(true);"
        onmouseover="hilite('refresh')"
        onmouseout="unhilite('refresh')"                        
        id="refresh">
        Refresh</a></td>
    <td><a href="javascript:;"
        onclick="goFullScreen('<? self::init()->fullscreen(); ?>');"
        onmouseover="hilite('fullscr')"
        onmouseout="unhilite('fullscr')"
        id="fullscr">
        Full Screen</a></td>
    <td><a href="javascript:;"
        onclick="favorite_this(document.getElementById('favorite_icon'),
            '<? echo $id; ?>');
            clickFlash('#favorite_icon');"
        onmouseover="hilite('favorite')"
        onmouseout="unhilite('favorite')"
        id="favorite">
        Favorite</a></td>
</tr>
</table>

<? else: ?>
<table>
<tr class="webfont">
    <td><a href="javascript:;" 
        onclick="clickFlash(this);reloadImage(false);"
        onmouseover="hilite('refresh')"
        onmouseout="unhilite('refresh')"
        id="refresh_icon">
        &#42;</a></td>
    <td><a href="javascript:;" 
        onclick="goFullScreen('<? self::init()->fullscreen(); ?>');"
        onmouseover="hilite('fullscr')"
        onmouseout="unhilite('fullscr')"
        id="fullscr_icon">
        &#37;</a></td>
    <td><a href="javascript:;" 
        onclick="laika_alert('Please login to mark items as favorite.','warning');clickFlash(this);"
        onmouseover="hilite('favorite')"
        onmouseout="unhilite('favorite')"
        id="favorite_icon"><? echo $fav; ?></a></td>
</tr>
<tr class="label">
    <td><a href="javascript:;"
        onclick="clickFlash('#refresh_icon');reloadImage(false);"
        onmouseover="hilite('refresh')"
        onmouseout="unhilite('refresh')"                        
        id="refresh">
        Refresh</a></td>
    <td><a href="javascript:;"
        onclick="goFullScreen('<? self::init()->fullscreen(); ?>');"
        onmouseover="hilite('fullscr')"
        onmouseout="unhilite('fullscr')"
        id="fullscr">
        Full Screen</a></td>
    <td><a href="javascript:;"
        onclick="laika_alert('Please login to mark items as favorite.','warning');clickFlash('#favorite_icon');"
        onmouseover="hilite('favorite')"
        onmouseout="unhilite('favorite')"
        id="favorite">
        Favorite</a></td>
</tr>
</table>
<? endif; ?>