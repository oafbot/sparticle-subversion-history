<?php
$id   = self::init()->user;
$user = LAIKA_User::load($id);
$avatar = LAIKA_Avatar::img($user->email(),120);
?>
<? self::add_style('user'); ?>
<div id="container">
    <article id="page-content">
        <? echo $avatar; ?>
        <table id="user_data">
            <tr>
                <td><h2 id="username"><? echo $user->username(); ?>.</h2></td>
            </tr>            
            <tr>
                <td><h3 id="realname"><? echo $user->name(); ?></h3></td>
            </tr>
            <tr>
                <td <? echo $user->logged_in() ? 'class=online' : 'class=offline' ?> >
                    <h4 id="login"><? echo $user->logged_in() ? USER_ICON." online" : USER_ICON." offline"; ?></h4>
                </td>
            </tr>
        </table>
    </artice>
    <br />
</div>
<div id="container">
    <? $last = FOLIO_Media::last(1,array('user'=>$id)); ?>
    <? //$collection = FOLIO_Media::last(6,array('user'=>$id)); ?>
    
    <? if( isset($last) ): ?>
        <img src="<? echo LAIKA_Image::api_path($last->path, 'auto', 500 ); ?>" />
    <? endif; ?>
    
    <p>    
    <? //if( isset($collection) ): ?>
        <? //$collection->shift(); ?>
        <? //self::render_foreach('user_content',$collection); ?>
        <? self::paginate('FOLIO_Media',8,array('user'=>$id),'user_content',array('DESC'=>'created')); ?>
    <? //endif; ?>
    </p> 
</div>