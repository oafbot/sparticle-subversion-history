<?php
$url = HTTP_ROOT.'/login/authenticate/';
$signup = HTTP_ROOT.'/account/create';

$content = <<<CONTENT
<div id="container">
    <form id="login" method="post" action="{$url}" >
        <fieldset>
            <legend>Login:</legend>
            <div>
                <label>User
                    <input type="text" name="user" id="user" />
                </label>&nbsp;&nbsp;
                <label>Password
                    <input type="password" name="password" id="password" />
                </label>&nbsp;&nbsp;
                <label>
                    <input type="submit" name="button" id="login_button" 
                        value="login"/>
                </label>
                <div id=signup>
                    <a href="$signup" >Sign up</a>
                </div>
            </div>        
         </fieldset>       
    </form>
</div>
CONTENT;
?>