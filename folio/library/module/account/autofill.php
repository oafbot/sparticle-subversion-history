<div id=container>
    <form id=account method=post action="<? self::path_to('/account/submit'); ?>" >
        <fieldset>
            <legend><h1>Registration</h1></legend>
            <br />
            <div>                
                <label>Username</label><br />
                <input type=text name=username id=username autofocus=true required=true value=
                    <? self::autofill('username'); ?>                     
                />
                <br />                
                <label>Password</label><br />
                <input type=password name=password id=password required=true value=
                    <? self::autofill('password'); ?> 
                />
                <input type=password name=verify id=verify placeholder="retype password" required=true value=
                    <? self::autofill('verify'); ?> 
                />
                <br />
                <br />
                <label>Name</label><br />
                <input type=text name=firstname id=firstname placeholder=first required=true value=
                    <? self::autofill('firstname'); ?> 
                />
                <input type=text name=lastname id=lastname placeholder=last required=true value=
                    <? self::autofill('lastname'); ?> 
                />                
                <br />
                <label>Email</label><br />
                <input type=email name=email id=email required=true value=
                    <? self::autofill('email'); ?> 
                />
                <br />
                <br />
                <label>
                    <input type=submit name=button id=signup_button 
                        value="Sign Up" onclick="validate();return false;"/>
                </label>
            </div>        
         </fieldset>       
    </form>
</div>