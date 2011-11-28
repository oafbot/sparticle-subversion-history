/* 
  script modified from original at: 
  http://www.ultramegatech.com/blog/2010/10/create-an-upload-progress-bar-with-php-and-jquery/ 
*/
(function($){
    var pbar;
    var started = false;

    $(function(){
        $('#upload-form').submit(function(){
            pbar = $('#progress-bar');
            pbar.show().progressbar();
            $('#upload-list').hide();
          
            //We know the upload is complete when the frame loads
            $('#upload-frame').load( function(){ started = true; } );
            
            setTimeout( function(){updateProgress($('#uid').val()); }, 500 );
        });
    });

    function updateProgress(id){
        var time = new Date().getTime();
        
        $.get('progress', { uid: id, t: time }, function(data){
            var progress = parseInt(data, 10);

            if(progress < 100 || !started){
                started = progress < 100;
                updateProgress(id);
            }            
            started && pbar.progressbar('value', progress);
        });
    }
}(jQuery));