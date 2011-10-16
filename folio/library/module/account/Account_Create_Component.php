<?php
$url = HTTP_ROOT.'/account/submit';
if(!isset($autofill))
$content = <<<CONTENT
<div id=container>
    <form id=account method=post action="{$url}" >
        <fieldset>
            <legend><h1>Registration</h1></legend>
            <br />
            <div>                
                <label>Username</label><br />
                <input type=text name=username id=username autofocus=true required=true />
                <br />                
                <label>Password</label><br />
                <input type=password name=password id=password required=true/>
                <input type=password name=verify id=verify placeholder="retype password" required=true />
                <br />
                <br />
                <label>Name</label><br />
                <input type=text name=firstname id=firstname placeholder=first required=true />
                <input type=text name=lastname id=lastname placeholder=last required=true />                
                <br />
                <label>Email</label><br />
                <input type=email name=email id=email required=true />
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
CONTENT;
else
$content = <<<CONTENT
<div id=container>
    <form id=account method=post action="{$url}" >
        <fieldset>
            <legend><h1>Registration</h1></legend>
            <br />
            <div>                
                <label>Username</label><br />
                <input type=text name=username id=username autofocus=true required=true value={$autofill['username']} />
                <br />                
                <label>Password</label><br />
                <input type=password name=password id=password required=true value={$autofill['password']} />
                <input type=password name=verify id=verify placeholder="retype password" required=true value={$autofill['verify']} />
                <br />
                <br />
                <label>Name</label><br />
                <input type=text name=firstname id=firstname placeholder=first required=true value={$autofill['firstname']} />
                <input type=text name=lastname id=lastname placeholder=last required=true value={$autofill['lastname']} />                
                <br />
                <label>Email</label><br />
                <input type=email name=email id=email required=true value={$autofill['email']} />
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
CONTENT;
