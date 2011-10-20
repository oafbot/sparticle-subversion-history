<?php

//$name     = $user->name();
//$email    = $user->email();
//$username = $user->username();
//var_dump();
//$user = LAIKA_User::init();
//unset($user);
//LAIKA_User::init()->destroy();
//$user = LAIKA_User::init()->switch_instance(self::init()->user);;
$id = self::init()->user;
$user = LAIKA_User::load($id);
//$user::init();
$avatar   = LAIKA_Avatar::img($user->email(),120);
$user->logged_in() ? $login = "logged in" : $login = "logged out";
//var_dump(LAIKA_User::active());
//var_dump($user);
?>

<div id="container">
    <article id="page-content">
        <?php echo $avatar; ?>
        <table>
            <tr>
                <td>User:&nbsp;&nbsp;</td>
                <td>&nbsp;<?php echo $user->username(); ?></td>
            </tr>            
            <tr>
                <td>Name:&nbsp;&nbsp;</td>
                <td>&nbsp;<?php echo $user->name(); ?></td>
            </tr>
            <tr>
                <td>Email:&nbsp;&nbsp;</td>
                <td>&nbsp;<?php echo $user->email(); ?></td>
            </tr>
            <tr>
                <td>Status:&nbsp;&nbsp;</td>
                <td>&nbsp;<?php echo $login; ?></td>
            </tr>
        </table>
    </artice>
</div>
