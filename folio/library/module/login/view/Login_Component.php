<div id="container">
    <form id="login" method="post" action="<? self::path_to('/login/authenticate/'); ?>" >
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
                    <? self::link_to('Sign up','/account/create'); ?>
                </div>
            </div>        
         </fieldset>       
    </form>
</div>