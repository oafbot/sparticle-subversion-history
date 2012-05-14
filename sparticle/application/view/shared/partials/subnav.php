<nav id="subnav">    
<ul>
<? if(isset(self::init()->submenu)): ?>
    <? foreach( self::init()->submenu as $text => $path ): ?>
        <li><? self::link_to($text,$path); ?></li>
    <? endforeach; ?> 
<? endif; ?>
</ul>
</nav>