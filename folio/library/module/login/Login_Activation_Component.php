<?php
$url = HTTP_ROOT.'/account/resend_confirmation/';

$content = <<<CONTENT
<div id=container>
    <pre>Your account needs to be activated before you can log in.
Please enter your email address below, and a confirmation key will be sent to you.
    </pre>
    <form id="login" method="post" action="{$url}" >
        <fieldset>
            <div>
                <label>Email
                    <input type="email" name="email" id="email" required="true"/>
                </label>&nbsp;&nbsp;
                <label>
                    <input type="submit" name="button" id="login_button" value="send"/>
                </label>
            </div>        
         </fieldset>       
    </form>
</div>
CONTENT;
