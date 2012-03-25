<?php
$id   = self::init()->user;
$user = LAIKA_User::load($id);
$avatar = LAIKA_Avatar::img($user->email(),120);
?>
<? self::add_style('user'); ?>
<div id="container">
    <article id="page-content">
        <? echo $avatar; ?>
        <table id="user_data">
            <tr>
                <td><h2 id="username"><? echo $user->username(); ?>.</h2></td>
            </tr>            
            <tr>
                <td><h3 id="realname"><? echo $user->name(); ?></h3></td>
            </tr>
            <tr>
                <td><h4 id="login"><? echo $user->logged_in() ? "online" : "offline"; ?></h4></td>
            </tr>
        </table>
    </artice>
    <br />
</div>