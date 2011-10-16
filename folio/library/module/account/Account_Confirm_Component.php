<?php
if( isset($status) ):
    if($status):
        $text = "You are now logged in.";
        $content = "<div id=container><pre>$text</pre></div>";
    else: 
        $text = "Please enter your email address below to request for a new confirmation key.";        
        $url = HTTP_ROOT.'/account/resend_confirmation/';
        $content = <<<CONTENT
<div id=container>
    <pre>$text</pre>
    <br/>
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
    endif;
else:
    $text = "We've sent a confirmation key to your email address. 
Please click on the link in the email to activate your account.";
    $content = "<div id=container><pre>$text</pre></div>";
endif;
