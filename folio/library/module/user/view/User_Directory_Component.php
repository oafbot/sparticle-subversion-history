<?php
$table = "";
foreach(self::init()->users as $user):
    $table .= '<tr class=user><td class=avatar>'.LAIKA_Avatar::img($user['email'],80).'</td><td><table class=info>';
    foreach($user as $key => $value)
        $table .= "<tr><td>&nbsp;$value</td></tr>";
    $table .= "</table></td></tr>";
endforeach;
?>
<div id="container">
    <article id="page-content">
        <h1>Users</h1>
        <br/>
        <table id=directory>
            <?php echo $table; ?>
        </table>
    </artice>
</div>

