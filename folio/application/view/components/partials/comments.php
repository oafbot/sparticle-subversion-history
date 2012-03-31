<? self::add_style('comment'); ?>
<link rel="stylesheet" href="<? echo HTTP_ROOT; ?>/js/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css" />
<? self::scripts('comment','/jquery-ui/js/jquery-ui');   ?>

<? $type = $parameters['parent_type']; $id = $parameters['parent_id']; ?>

<div id="comment_module">
    <div class="controls dark upper">
        <h1 id="comment_header"><? echo COMMENT_ICON; ?>&nbsp; Comments :</h1>
        <div id="pagination">
        
        <? FOLIO_Comment::render_ajax_pagination(10,$parameters,'comment'); ?>
        </div>   
    </div>

    <? if(LAIKA_Access::is_logged_in()): ?>
    <form onsubmit="return false;" id="comment_form">
        <? echo LAIKA_User::active()->avatar(50); ?>        
        <img src="<? echo IMG_DIRECTORY.'/pointer.png'; ?>" class="pointer"/>
        <textarea id="comment" name="comment" onfocus="focus_comment();" onblur="unfocus_comment();" placeholder=""></textarea>
        <input type="hidden" name="user" value="<? echo LAIKA_User::active()->id; ?>" />
        <input type="hidden" name="parent_type" value="<? echo $type; ?>" />
        <input type="hidden" name="parent_id" value="<? echo $id; ?>" />
        <button value="Post" class="button blue medium" id="post_comment" onclick="add_comment()">Post</button>                       
    </form>

    <? else: ?>        
        <? self::set_login_redirect(); ?>
        <div id="no_login">
        <? echo LAIKA_Avatar::img('bogus@example.com',50); ?>
        <img src="<? echo IMG_DIRECTORY.'/pointer.png'; ?>" class="pointer"/>
        <p class="comment_bubble">
            Please
            <a href="<? echo self::path_to('/login/'); ?>" style="font-size:small;" >
                 login<? echo LOGIN_ICON; ?>
            </a>
            to post comments.
        </p>
        </div>          
    <? endif; ?>

    <div id="thread">
        <? self::paginate('FOLIO_Comment', 10, array('parent_type'=>$type,'parent_id'=>$id), 
               'comment_thread', array('DESC'=>'created')); ?>
    </div>
</div>

<div id="pop-up" title="Delete Comment?" style="display:none;">
	<p><? echo ALERT_ICON; ?> The comment will be permanently deleted.</p>
</div>