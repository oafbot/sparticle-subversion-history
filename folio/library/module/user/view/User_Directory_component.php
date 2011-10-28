<?php

$table = "";
foreach(self::init()->users as $user):
    $table .= '<tr><td>'.LAIKA_Avatar::img($user['email'],80).'</td></tr>';
    foreach($user as $key => $value)
        $table .= "<tr><td>$key:&nbsp;&nbsp;</td><td>&nbsp;$value</td></tr>";
    $table .= "<tr><td>&nbsp;&nbsp;</td></tr>";
endforeach;

?>


<div id="container">
    <article id="page-content">
        <h1>Users</h1>
        <br/>
        <table>
            <?php echo $table; ?>
        </table>
    </artice>
</div>

