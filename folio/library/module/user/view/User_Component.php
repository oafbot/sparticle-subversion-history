<?php
$id   = self::init()->user;
$user = LAIKA_User::load($id);

$avatar   = LAIKA_Avatar::img($user->email(),120);
$user->logged_in() ? $login = "logged in" : $login = "logged out";
?>

<div id="container">
    <article id="page-content">
        <? echo $avatar; ?>
        <table>
            <tr>
                <td>User:&nbsp;&nbsp;</td>
                <td>&nbsp;<? echo $user->username(); ?></td>
            </tr>            
            <tr>
                <td>Name:&nbsp;&nbsp;</td>
                <td>&nbsp;<? echo $user->name(); ?></td>
            </tr>
            <tr>
                <td>Email:&nbsp;&nbsp;</td>
                <td>&nbsp;<? echo $user->email(); ?></td>
            </tr>
            <tr>
                <td>Status:&nbsp;&nbsp;</td>
                <td>&nbsp;<? echo $login; ?></td>
            </tr>
        </table>
    </artice>
    <br />
    <? self::link_to("Upload Files","/upload/"); ?>
</div>