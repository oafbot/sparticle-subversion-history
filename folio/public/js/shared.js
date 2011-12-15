function laika_alert(message,type){
    $('#alert').remove();
    $.get('api/alert', { 'message':message, 'type':type }, function(data) {
        $('#subnav').after(data);
    }
    );
}

function close_alert(){
    $('#alert').text(' ');
    $('#alert').animate({
    opacity: 0.1,
    width: 0
  }, 500, function() {
    $('#alert').slideUp();
  });
    
}

function loading(){
    $('.loader').fadeIn(1000);
    $('.loader').text(counter);
    counter++;
    if(counter == 7)
        counter = 0;
}

function endload(){
   $('.loader').fadeOut(1000);
   clearInterval(timer);       
}

function fullscreen(src){
    var html = '<div id=fullscreen onclick="exit_fullscreen()"><table height="100%" width="100%"><tbody><tr><td align="center" valign="middle"><img src="'+src+'" id=large_image onclick="goto_image(\''+src+'\');"/></td></tr></tbody></table></div>';

//<tr><td align="center">press any key to exit</td></tr>    
//<div>press any key to exit</div>

    $('#main').before(html);
    $('#footer').hide();
    $('#fullscreen').fadeIn(1000, function(){
        $('#main').hide();
    });
    document.onkeypress = function(){
        exit_fullscreen();
    }        
}

function goto_image(src){
    //window.location = src;    
}

function exit_fullscreen(){
    $('#main').show();
    $('#footer').show();
    $('#fullscreen').fadeOut(1500, function(){
        $('#fullscreen').remove();
    });
}