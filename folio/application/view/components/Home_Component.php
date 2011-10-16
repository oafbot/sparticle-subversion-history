<?php
$img = HTTP_ROOT.'/images/kewpie2.jpg';

$hidden = <<<HIDDEN
            <p></p>
            <img src="$img" width="300" alt="laika" style="border-radius:5px;border:#bbb solid 1px;">
        </section>
        <aside>	
            <p></p>
        </aside>
HIDDEN;

if(LAIKA_Access::is_logged_in())
    $inner = $hidden;
else $inner = " ";

$content = <<<CONTENT
<div id="container">
    <article id="page-content">
        <section>
        <h1 style="display:inline-block;">Welcome to&nbsp;</h1><h1 class="pacifico" style="display:inline-block;font-size:xx-large;">Sort&nbsp;*folio</h1>
            <!--<p>Sort&#149;folio is an opensource platform for setting up a simple online portfolio</p>-->
        $inner
    </article>
</div>            
CONTENT;
?>