<div id="container" class="directory">
    <h1 class="pacifico">Users.</h1>
    <div id="list">
        <table id=directory>
        <? foreach(self::init()->users as $array): ?>
            <? $user = LAIKA_User::from_array($array); ?>
            <tr class=user>
                <td>
                    <? echo $user->avatar(80); ?>
                </td>
                <td>
                    <table class=info>
                        <tr>
                            <td class="pacifico username"><? echo $user->username; ?></td>
                        </tr>
                        <tr/>
                            <td class="realname"><? echo $user->name(); ?></td>                        
                        </tr>
                        <tr>
                            <td <? echo $user->logged_in() ? 'class=online' : 'class=offline' ?>>
                            <? echo $user->logged_in() ? USER_ICON." online" : USER_ICON." offline"; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <? endforeach; ?>
        </table>
    </div>
</div>