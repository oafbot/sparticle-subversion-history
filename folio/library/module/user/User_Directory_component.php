<?php
/*
$name     = $user::get('firstname')." ".$user::get('lastname');
$email    = $user::get('email');
$username = $user::get('username');
$user::get('logged_in') == 1 ? $login = "logged in" : $login = "logged out";
$avatar   = get_gravatar($email);
*/
    $table = "";
    foreach($users as $user):
        $table .= '<tr><td>'.LAIKA_Avatar::img($user['email'],80).'</td></tr>';
        foreach($user as $key => $value)
            $table .= "<tr><td>$key:&nbsp;&nbsp;</td><td>&nbsp;$value</td></tr>";
        $table .= "<tr><td>&nbsp;&nbsp;</td></tr>";
    endforeach;



$content = <<<CONTENT
<div id="container">
    <article id="page-content">
        <h1>Users</h1>
        <br/>
        <table>
            $table
        </table>
    </artice>
</div>
CONTENT;
