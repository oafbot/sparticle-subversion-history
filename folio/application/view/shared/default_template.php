<?php
/**
 *	 
 *
 *	@filesource     default_tmpl.php
 *
 *	@version        0.1.0b
 *	@package        FOLIO
 *	@subpackage     view
 *	@category       template
 *	@date           2011-05-21 03:57:05 -0400 (Sat, 21 May 2011)
 *
 *	@author         Leonard M. Witzel <witzel@post.harvard.edu>
 *	@copyright      Copyright (c) 2011  Laika Soft <{@link http://oafbot.com}>
 *
 */
include_once('header.php');
include_once('footer.php'); 
include_once('navbar.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<!-- 
                 .      . 
                / \    / \
               / ^ \__/ ^ \
              |            |
             |              |
            |   ––.    .––   |
            |    O;    :X    |
            /                 \
           /  ––– . ( ) . –––  \
          (   –––  . | .  –––   )
           \  ––– .  |  . –––  /
            \_______/ \_______/    __
            / \__/ / /______/ \   /  \
           /     \/_/          \  |  |
          |                     |/   /
          |      /       \      |   |
         |      |         |      | /
         |      |    X    |      |-
        /       \__     __/       \
        | . . . |  –––––  | . . . |
         \i-i-i/___/   \___\i-i-i/   
         
     %%%%            %%%%
    %%%%%   %%%%   %%    %%  %%  %%  %%%%
    %  %%      %%  %%   %%%  %%  %      %%
    %  %%  %%%%%%  %%  % %%  %%%%   %%%%%%
   %%  %%  %%  %%  %% %  %%  %%  %  %%  %%
   %%  %%% %%%% %% %%%   %%  %%  %% %%%% %%
   ––––––––––––––––––––––––––––––––––––––––                        
     –––– E    N    G    I    N    E ––––
        –––                        –––
                
-->
<!-- meta tags -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
   
    <title>
        <?php echo APPLICATION_TITLE; ?>
    </title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<!-- stylesheets -->
<!--<link href="stylesheets/style0.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="<?php echo HTTP_ROOT.'/stylesheets/reset.css';?>" type="text/css">
    <link rel="stylesheet" href="<?php echo HTTP_ROOT.'/stylesheets/common.css';?>" type="text/css">
    <link rel="stylesheet" href="<?php echo HTTP_ROOT.'/stylesheets/layout.css';?>" type="text/css">
    <link rel="stylesheet" href="<?php echo HTTP_ROOT.'/stylesheets/forms.css';?>" type="text/css">
    <link rel="stylesheet" href="<?php echo HTTP_ROOT.'/stylesheets/corners.css';?>" type="text/css">
    <?php // echo $styles; ?>
<!-- javascript -->   
<!--<script type="text/javascript" src="js/shared.js"></script> -->
    <script src="<?php echo HTTP_ROOT.'/js/jquery.js';?>"></script>
    <?php // echo $javascript ?> 
<!--conditional comments -->
<!--[if IE]><script src="js/html5.js"></script><![endif]-->   
</head>
<body class="home">
    <div id="main">
        <?php echo $header; ?>
        <?php echo $navbar; ?>
        <?php if(isset($alert))echo '<div id="alert" class="'.$alert_type.'">'.$alert.'</div>'; ?>    
        <?php echo $content; ?>               
            
    </div>
    <?php echo $footer; ?>
</body>
</html>