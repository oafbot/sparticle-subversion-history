<?php
$images  = IMG_DIRECTORY;
$content = <<<CONTENT
<div id="container">
    <img src="$images/error.png" alt="error" style="display:inline-block;"/>
    <h2 class="pacifico" style="display:inline-block;top:-75px;margin-left:30px;position:relative;">
        404: File not found.
    </h2>
</div>
CONTENT;
?>