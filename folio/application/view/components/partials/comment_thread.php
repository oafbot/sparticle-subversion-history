<? $user = LAIKA_User::load($object->user); ?>
<div class="comment_box" id="<? echo $object->id; ?>">
    <? echo $user->avatar(50); ?>
    <img src="<? echo IMG_DIRECTORY.'/pointer.png'; ?>" class="pointer"/>
    <p class="comment_bubble"><? echo $object->comment; ?></p>
    <div class="comment_info">
        <? echo USER_ICON; ?>
        <? $user->link_to_user(); ?>
        <br />
        <? echo TIME_ICON; ?>
        <? echo $object->created_to_datetime(); ?>
    </div>
    <br />
</div>