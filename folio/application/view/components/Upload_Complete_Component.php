<div id="container" style="background-color:#eee;">
The following files were uploaded.
<br />  
<p>
<? if(isset(self::init()->upload))
       $params = explode('+',self::init()->upload);
   foreach($params as $key => $value) 
       echo '<a href='.HTTP_ROOT.'/media/'.LAIKA_User::active()->username.'/'.$value.' >
             <img src='.HTTP_ROOT.'/media/'.LAIKA_User::active()->username.'/'.$value.' class="upload_image" /></a>';?>
</p>
<p>
<? self::link_to("Upload more files...","/upload/",array("class"=>"button black medium bigrounded","id"=>"upload_more")); ?>
</p>
</div>