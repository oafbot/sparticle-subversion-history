<?php

//$name     = $user->name();
//$email    = $user->email();
//$username = $user->username();
$avatar   = LAIKA_Avatar::img($user->email(),120);
$user->logged_in() ? $login = "logged in" : $login = "logged out";

$content = <<<CONTENT
<div id="container">
    <article id="page-content">
        $avatar
        <table>
            <tr>
                <td>User:&nbsp;&nbsp;</td>
                <td>&nbsp;{$user->username()}</td>
            </tr>            
            <tr>
                <td>Name:&nbsp;&nbsp;</td>
                <td>&nbsp;{$user->name()}</td>
            </tr>
            <tr>
                <td>Email:&nbsp;&nbsp;</td>
                <td>&nbsp;{$user->email()}</td>
            </tr>
            <tr>
                <td>Status:&nbsp;&nbsp;</td>
                <td>&nbsp;$login</td>
            </tr>
        </table>
    </artice>
</div>
CONTENT;
