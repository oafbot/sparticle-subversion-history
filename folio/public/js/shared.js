function laika_alert(message,type){
    $.get('api/alert', { 'message':message, 'type':type }, function(data) {
        $('#alert').remove();
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
    $('#alert').slideUp(200,function(){$('#alert').remove();});
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
    var logo = '<div id="logo_absolute"><img src="'+root_url+'/images/logo_white.svg" type="image/svg+xml" id="logo"/><h2 class=pacifico>Sparticle *</h2></div>';

    var html = logo+'<div id=fullscreen onclick="exit_fullscreen()"><table height="100%" width="100%"><tbody><tr><td align="center" valign="middle"><img src="'+src+'" id=fullscreen_content onclick="goto_image(\''+src+'\');"/></td></tr></tbody></table></div>';

//<tr><td align="center">press any key to exit</td></tr>    
//<div>press any key to exit</div>

    $('#main').before(html);
    $('#footer').hide();
    $('#logo_absolute').fadeIn(1000);
    //$('#fullscreen_content').load( function(){
        $('#fullscreen').fadeIn(1000, function(){
            $('#main').hide();
        });
    //});
    //document.documentElement.style.overflow = 'hidden';
    //document.body.scroll = "no";
    document.onkeypress = function(){
        exit_fullscreen();
    }        
}

function goto_image(src){
    //window.location = src;    
}

function enterFullScreen(src){        
    var t=setTimeout("fullscreen('"+src+"')",1000);    
}

function exit_fullscreen(){
    $('#main').show();
    $('#footer').show();
    $('#logo_absolute').fadeOut(800);
    $('#fullscreen').fadeOut(1500, function(){
        $('#fullscreen').remove();
        $('#logo_absolute').remove();
        //document.documentElement.style.overflow = 'visible';
    });
}

function ajax_pagination(page,controller){
    //alert(controller+'?p='+page);
    $.get(root_url+'/'+controller+'?p='+page, function(response){
        
        //alert(response.value);
                             
    }, "json" );    
}