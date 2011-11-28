<? self::scripts('user'); ?>
<? $user = self::init()->user; ?>
<div id="container">
    <form method=post action="<? self::path_to('/assets/save'); ?>">
        <div class="controls dark upper">
            <div class="toolbar left">
                <? self::link_to('<span style="font-family:\'WebFont\';font-size:medium;">&lt;</span>','/assets',
                    array('class'=>'inset_button'), array('p'=>self::init()->pagination)); ?>
            </div>
            <div class="toolbar center">
                Edit Image Information
            </div>
            <div class="toolbar right">
                <input type="submit" value="Save" class="button blue medium" />
            </div>       
        </div>
        <div id="edit_list">
            <table>
            <? self::render_foreach('assets_edit', self::init()->editables); ?> 
            </table>    
        </div>
    </form> 
    <div class="controls dark lower">
    </div>
</div>  