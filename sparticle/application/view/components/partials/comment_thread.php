<? $user = LAIKA_User::load($object->user); ?>
<div class="comment_box" id="<? echo $object->id; ?>">
    <? echo $user->avatar(50); ?>
    <img src="<? echo IMG_DIRECTORY.'/pointer.png'; ?>" class="pointer"/>
    <p class="comment_bubble"><? echo $object->comment; ?></p>
    <div class="comment_info">
        <div class="data">
        <? echo USER_ICON; ?>
        <? $user->link_to_user(); ?>
        <br />
        <? echo TIME_ICON; ?>
        <? echo $object->created_to_datetime(); ?>
        </div>
        <div class="tools">
        
        <? if( $object->is_owner() ): ?> 
            <a href="javascript:;" onclick="delete_comment(<? echo $object->id; ?>);">
            <h3 class="delete">
                <? echo TRASH_ICON; ?> delete
            </h3>
            </a>
        <? endif; ?>
        
        </div>       
    </div>
    <br />
</div>