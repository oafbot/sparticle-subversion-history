<?php
if(isset(self::init()->page))
    $page = self::init()->page;

if(LAIKA_Access::is_logged_in())
    $user_tab = LAIKA_User::active()->username();
else
    $user_tab = "user";
    
$links = array("Sparticle","About","Login",$user_tab);

foreach( $links as $key => $tab ){
    if(isset($page))
        $nav[] = style_change($page,$tab);
    else $nav[] = " ";
}

function style_change($page,$tab){
    if(ucfirst($page) == ucfirst($tab))
        return "current";
    return " ";        
}

?>

<div id=menu>
    <nav id=main-navigation>
    	<ul>
    	    <li class="<? echo $nav[0]; ?>" id="navbar_home">
    	       <a href="<? echo HTTP_ROOT; ?>">
    	           <span class="webfont">&nbsp;</span>
    	           <? echo $links[0]; ?>
    	       </a>
    	    </li>
    	    
    	    <? if(LAIKA_Access::is_logged_in()): ?>
    	       <li class="<? echo $nav[3] ?>">
                    <? self::link_to(USER_ICON." $user_tab", '/user/'); ?>
    	       </li>    	       
            <? endif; ?>
            
            <li class="<? echo $nav[2]; ?>">
                <a href="<? echo LAIKA_Access::is_logged_in() ? HTTP_ROOT.'/logout/' : HTTP_ROOT.'/login/'; ?>">
                <? echo LAIKA_Access::is_logged_in() ? LOGIN_ICON.' Logout' : LOGIN_ICON.' Login'; ?></a>
            </li>
        </ul>
    </nav>
</div>