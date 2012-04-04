jQuery(function( $ ){
    $.preload( '#featured img');
    $.preload( '#flip img');
    $.preload( '#latest img', {		
        placeholder: root_url+'/api/image?src=/images/placeholder.png&rp=150x25x50',		
		threshold: 5, //how many at a time, to load.
        //notFound:
        //onRequest:request,
		onComplete: function(){$.preload('#next_set img');}
		//onFinish:finish,
	});
	$('#next a').click(function(){
	   var id = $('.current_set').attr('id');
	   var page = Number(id.substring(4));
	   switch_thumbs(page,'next');
	});
    $('#back a').click(function(){
	   var id = $('.current_set').attr('id');	   
	   var page = Number(id.substring(4));	   
	   switch_thumbs(page,'prev');
	});
});

function reloadImage(login){
    counter = 0;
    timer   = setInterval(loading,80);
    
    $.get(root_url+'/home/reload_image', function(data) {
          
        $('#featured').remove();
        $('#flip').remove();
        $('#permalink').remove();
        
        $('#image').append('<a href='+data.permalink+' id=permalink >');
        $('#permalink').append('<img src='+data.image+' id=featured />');
        $('#permalink').append('<img src='+data.reflection+' id=flip />');

        $('#featured').css('display','none');
        $('#flip').css('display', 'none');
        
        $('#flip').load(function(){$('#featured').fadeIn(2000);});
        $('#flip').load(function(){$('#flip').fadeIn(2000);endload();});

        $('#fullscr').attr("onclick","goFullScreen('"+data.path+"')");
        $('#fullscr_icon').attr("onclick","goFullScreen('"+data.path+"')");
                
        $('#image_name').text(data.title);
        $('.user').text(data.user);
        $('.user').attr('href',root_url+'/user/'+data.user);        
        
        $('#favorite_icon').text(data.favorite);
        
        if(login){
            $('#favorite_icon').attr('onclick',"favorite_this(document.getElementById('favorite_icon'),"+data.id+");clickFlash('#favorite_icon');");
            $('#favorite').attr('onclick',"favorite_this(document.getElementById('favorite_icon'),"+data.id+");clickFlash('#favorite_icon');");
        }
        else{
            $('#favorite_icon').attr('onclick',"laika_alert('Please login to mark items as favorite.','warning');clickFlash('#favorite_icon');");
            $('#favorite').attr('onclick',"laika_alert('Please login to mark items as favorite.','warning');clickFlash('#favorite_icon');");
        }
        
    }, "json" );
    
    unhilite('fullscr');
    unhilite('refresh');
    unhilite('favorite');   
}


function favorite_this(element,id){
    if(element.childNodes[0].nodeValue == 'O'){
        element.childNodes[0].nodeValue = 'N';
        $.get('home/favorite', {"id" : id} );
    }
    else{
        element.childNodes[0].nodeValue = 'O';
        $.get('home/unfavorite', {"id" : id} );
    }
}

function clickFlash(element){
    var pos = $(element).position();
    var parent = $(element).parent();
    var grandparent = $(parent).parent();
    var clone = $(parent).clone();
    var left = $(element).marginLeft;
    var top = $(element).marginTop;
    var size =  parseFloat($(element).css('font-size'));
    
    $(clone).css('position','absolute');
    $(clone).css('z-index',11);
    $(clone).css('vertical-align','middle');
    $(clone).css('top',  pos.top  - $(clone).height()/2  );
    $(clone).css('left', pos.left - $(clone).width()/2   );    
    $(clone).css('margin',0);
    $(clone).children(":first").removeAttr('onclick');
    
    $(clone).appendTo(grandparent);
    $(clone).children(":first").css('color','#666');    
    $(clone).animate({
        fontSize: size*3,
        opacity:0.3,
        top: pos.top  - $(clone).height()/2,
        left: pos.left  - $(clone).width()/2,
        marginTop: -$(clone).height()/2,
        marginLeft: -$(clone).width()/2
    },1000,
        function(){
            $(clone).fadeOut(500,function(){$(clone).remove()});
        });    
}

function hilite(element){
    $('#'+element).css('opacity',1);
    $('#'+element).css('color','#83c0ff');
    $('#'+element+'_icon').css('opacity',1);
    $('#'+element+'_icon').css('color','#83c0ff');     
}

function unhilite(element){
    $('#'+element).css('opacity',0.3);
    $('#'+element).css('color','#666');
    $('#'+element+'_icon').css('opacity',0.3);
    $('#'+element+'_icon').css('color','#666');  
}

function goFullScreen(src){    
    clickFlash('#fullscr_icon');    
    //enterFullScreen();
    var t=setTimeout("fullscreen('"+src+"')",1000);
}

function switch_thumbs(set,dir){
    //var crnt_set = '#set-'+String(set);
    var sched_next = '#set-'+String(set+2);
    var sched_prev = '#set-'+String(set-2);        
    
    var current = '.current_set';
    var next    = '.next_set';
    var prev    = '.previous_set';
    
    if(dir == 'next' && $(next).length){  
        $(current).animate({left: '-=800'}, {duration: 1000, easing: 'easeOutBounce', complete: function(){
            
            if($(prev).length) $(prev).attr('class','out_of_scope_set');
            
            $(current).css('display','none');
            $(next).css('display','table');
            $(next).animate({left: '-=800'},{duration: 1000, easing: 'easeOutBounce'});
                        
            $(current).attr('class','previous_set');
            $(next).attr('class','current_set');
            page_set(set+1);

            if($(sched_next).length) $(sched_next).attr('class','next_set');                 
            else load_next_set();                
        }});}
    
    else if(dir == 'prev' && $(prev).length){        
        $(current).animate({left: '+=800'}, {duration: 1000, easing: 'easeOutBounce', complete: function(){
            $(prev).css('display','table');
            $(prev).animate({left: '+=800'},{duration: 1000, easing: 'easeOutBounce'});
            $(current).css('display','none');
            
            $(next).attr('class','out_of_scope_set');
            $(current).attr('class','next_set');
            $(prev).attr('class','current_set');
            if( $(sched_prev).length ) $(sched_prev).attr('class','previous_set');
            page_set(set-1);
        }});}
}

function load_next_set(){
    $.get(root_url+'/home/load_next', function(data) {
        if(data.length)
            $('.current_set').after(data);
        }, 'html');
}

function page_set(p){
    $.get(root_url+'/home/page_set', { page: p } );   
}
