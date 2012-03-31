function laika_alert(message,type){
    $.get(root_url+'/api/alert', { 'message':message, 'type':type }, function(data) {
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
    var page_width = pageWidth();
    var page_height = pageHeight();
    
    if(page_width > 800){        
        //var width  = page_width  - page_width  * 0.10;
        //var height = page_height - page_height * 0.10;                
        var width  = page_width  - 100;
        var height = page_height - 100;
        src = src.replace('c=800x600','op='+width+'x'+height);
    }
        
    var logo = '<div id="logo_absolute"><img src="'+root_url+'/images/logo_white.svg" type="image/svg+xml" id="logo"/><h2 class=pacifico>Sparticle *</h2> <h3>press any key to exit</h3></div>';

    var html = logo+'<div id=fullscreen onclick="exit_fullscreen()"><table height="100%" width="100%"><tbody><tr><td align="center" valign="middle"><img src="'+src+'" id=fullscreen_content /></td></tr></tbody></table></div>';

/*

<a href="javascript:goto_image(\''+src+'\');" title="view orignal">

*/

    $('#main').before(html);
    $('#footer').hide();
    $('#logo_absolute').fadeIn(1000);
    $('#fullscreen_content').load( function(){
        $('#fullscreen').fadeIn(1000, function(){
            $('#main').hide();
        });
    });
    //document.documentElement.style.overflow = 'hidden';
    //document.body.scroll = "no";
    document.onkeypress = function(){
        exit_fullscreen();
    }        
}

function goto_image(source){
/*
    source = decodeURIComponent(source);
    source = source.replace("/api/image?src=","");
    source = source.substring(0,source.length-12);    
    window.location = source;   
*/ 
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

function pageWidth() {return window.innerWidth != null? window.innerWidth: document.body != null? document.body.clientWidth:null;}

function pageHeight() {return window.innerHeight != null? window.innerHeight: document.body != null? document.body.clientHeight:null;}



function favorite(id){
    // If not favorite:
    if($('span.webfont.unfavorite').text()){
        $.get(root_url+'/favorite/favorite', {"id" : id}, function(data){
            
            if(data['login']){
                $('span.webfont.unfavorite').replaceWith('<span class="webfont favorite">N</span>');
                var txt = $('.label.favorite').text('Undo');
                
                var num = $('.favorite_count').text();
                $('.favorite_count').text(String(Number(num)+1));
                laika_alert('Item marked as a Favorite.','success');}
            else                   
                laika_alert('There was a problem processing your request. Are you logged in?','warning');
        }, 'json' );
    }
    else{ 
    // If favorite:
        $.get(root_url+'/favorite/unfavorite', {"id" : id},  function(data){
            
            if(data['login']){            
            $('span.webfont.favorite').replaceWith('<span class="webfont unfavorite">O</span>');
                $('.label.favorite').text('Favorite');
                
                var num = $('.favorite_count').text();
                $('.favorite_count').text(String(Number(num)-1));
                laika_alert('Item no longer marked as a Favorite.','success');}
            else                   
                laika_alert('There was a problem processing your request. Are you logged in?','warning');       
        }, 'json' );
    }
}
