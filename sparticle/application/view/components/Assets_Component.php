<? $user = self::init()->user; ?>
<div id="container">
    <form method=post action="<? self::path_to('/assets/action?p='.$_SESSION['pagination']); ?>" id="assets">
        <div class="controls dark upper" >
            <div class="toolbar left">
            <? FOLIO_Media::render_pagination(8,array('user'=>$user),'assets'); ?>
            </div>
            <div class="toolbar center">
                Media Files
            </div>
            <div class="toolbar right">
                <input type="submit" name="action" value="Edit"   class="button black medium" />
                <input type="submit" name="action" value="Delete" class="button black medium" id="delete"/>
            </div>            
        </div>
        <div id="items">       
            <table>
            <? self::paginate('FOLIO_Media',8,array('user'=>$user),'assets'); ?>
            <td>
                <a href=<? self::path_to('/upload'); ?> >
                    <div id=upload><span id=upload_label>Upload more</span></div>
                </a>
            </td>
            </tr>
            </table>
        </div>
    </form> 
    <div class="controls dark lower">
        <? FOLIO_Media::render_pagination(8,array('user'=>$user),'assets'); ?>
    </div>
</div>
<div id="pop-up" title="Delete Media?" style="display:none;">
	<p>WARNING: The selected media will be deleted permanently.</p>
</div>  