<!DOCTYPE html>
<html lang="en">
<head>
    <title><? echo APPLICATION_TITLE; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <? self::render('masthead'); ?>
    <? self::render('meta');     ?>

    <? self::styles('reset','common','layout','forms','buttons'); ?>  
    <? self::render('javascript'); ?>
    <? self::scripts('jquery','shared'); ?>

</head>
<body>
    <div id="main">
        <? self::render('header'); ?>
        <? self::render('navbar'); ?>
        <? self::render('subnav'); ?>
        <? self::render_alert();     ?>
        <? self::render_component(); ?> 
    </div>
    <? self::render('footer'); ?>
</body>
</html>