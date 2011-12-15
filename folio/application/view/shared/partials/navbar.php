<?php
$root = HTTP_ROOT;
$home = HTTP_ROOT.'/';
$about = HTTP_ROOT.'/about/';
$login = HTTP_ROOT.'/login/';
if(isset(self::init()->page))
    $page = self::init()->page;

if(LAIKA_Access::is_logged_in())
    $user_tab = LAIKA_User::active()->username();
else
    $user_tab = "user";
    
$links = array("Home","About","Login",$user_tab);

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
if(LAIKA_Access::is_logged_in()){
    $links[2] = "Logout";
    $login = HTTP_ROOT.'/logout/';
    $user = HTTP_ROOT.'/user/';
    $hidden = '<li class="'.$nav[3].'"><a href="'.$user.'">'.$links[3].'</a></li>';
}
else $hidden = "";
?>

<div id=menu>
    <nav id=main-navigation>
    	<ul>
    	    <li class="<?php echo $nav[0]; ?>"><a href="<?php echo $home; ?>"><?php echo $links[0]; ?></a></li>
            <li class="<?php echo $nav[1]; ?>"><a href="<?php echo $about; ?>"><?php echo $links[1]; ?></a></li>
            <?php echo $hidden; ?>
            <li class="<?php echo $nav[2]; ?>"><a href="<?php echo $login; ?>"><?php echo $links[2]; ?></a></li>
        </ul>
    </nav>
</div>
