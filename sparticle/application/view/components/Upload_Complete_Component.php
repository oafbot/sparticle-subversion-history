
<div id="container">
<div class="controls">
    <? self::link_to("Manage","/assets/",array("class"=>"button gray medium","id"=>"upload_more")); ?>
</div>
<p>The following files were uploaded.</p>  
<p>
<? if(isset(self::init()->upload))
       $params = explode('+',self::init()->upload);
   foreach($params as $key => $value) 
       echo '<a href='.HTTP_ROOT.'/media/'.LAIKA_User::active()->username.'/'.$value.' >
             <img src='.HTTP_ROOT.'/media/'.LAIKA_User::active()->username.'/'.$value.' class="upload_image" /></a>';?>
</p>
<div class=controls>
<? self::link_to("Upload more files...","/upload/",array("class"=>"button blue medium bigrounded","id"=>"upload_more")); ?>
</div>
</div>