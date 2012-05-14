<script language="javascript">$(function(){$('#user').focus();});</script>

<div id="container" class="clear">
    <article id="page-content">
        <section>
            <img src="<? self::path_to('/images/kewpie2.jpg'); ?>" width="300" alt="laika" id="img1">
            <img src="<? self::path_to('/images/waves.jpg'  ); ?>" width="200" alt="laika" id="img2">
            <img src="<? self::path_to('/images/cows.jpg'   ); ?>" width="200" alt="laika" id="img3">
            <img src="<? self::path_to('/images/spices.jpg' ); ?>" width="180" alt="laika" id="img4">
        </section>

        <aside id="login">  
        <div id=signup>
             <? self::link_to('Sign up '.CHECK_ICON,'/account/create'); ?>
        </div>
            <h1 class="pacifico" style="">Login</h1>
        <form id="login_form" method="post" autocomplete="off" action="<? self::path_to('/login/authenticate/'); ?>" >
        <fieldset>
            <!-- <legend>Login:</legend> -->
            <div>
                <table>
                <tr>
                    <td><label>User</label></td>
                    <td><input type="text" name="user" id="user" /></td>
                </tr>
                <tr>
                    <td><label>Password</label></td>
                    <td><input type="password" name="password" id="password" /></td>
                    <td><button class="button black" id="login_switch">login</button></td>
                </tr>
                </table>                             
            </div>        
        </fieldset>       
        </form> 
        </aside>

        <aside>	
            <h1 style="display:inline-block;color:#aaa;">Welcome to&nbsp;</h1>
            <h1 class="pacifico" style="display:inline-block;font-size:xx-large;color:#ccc;">
                <? echo APPLICATION_TITLE; ?>
            </h1>
            <p>
<!--
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            
-->
            <em>Sparticle</em> is a multi-user online portfolio. I built it as a simple content management system for presenting my artwork online, and as a demo of my web development toolset. 
            <p>
            Sparticle is built on <em>Laika</em>, a homebrewed bare-bones PHP framework. It is intended more as a proof of concept and certainly not the cat's pajamas, but if you would like to add, modify or otherwise contribute to extending the functionality of this product, both the <em>Laika Framework</em> and <em>Sparticle</em> are licenced under the BSD Lisence; Source code is available upon request. Thanks for your interest!<br />
            <span class="pacifico" style="float:right;font-size:medium">Leonard.</span>
            </p>
        </aside>
            
    </article>
</div>