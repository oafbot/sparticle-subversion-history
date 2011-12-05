<?php
$img1 = HTTP_ROOT.'/images/kewpie2.jpg';
$img2 = HTTP_ROOT.'/images/waves.jpg';
$img3 = HTTP_ROOT.'/images/cows.jpg';
$img4 = HTTP_ROOT.'/images/spices.jpg';
?>
<div id="container" class="clear">
    <article id="page-content">
        <section>
            <p></p>
            <img src="<? echo $img1; ?>" width="300" alt="laika" id="img1">
            <img src="<? echo $img2; ?>" width="200" alt="laika" id="img2">
            <img src="<? echo $img3; ?>" width="200" alt="laika" id="img3">
            <img src="<? echo $img4; ?>" width="180" alt="laika" id="img4">
        </section>
        <aside>	
            <h1 style="display:inline-block;color:#aaa;">Welcome to&nbsp;</h1><h1 class="pacifico" style="display:inline-block;font-size:xx-large;color:#ccc;"><? echo APPLICATION_TITLE; ?></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </aside>
    </article>
</div>