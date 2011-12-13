function reloadImage(){
    $.get('home/reload_image', function(data) {
          
        $('#featured').remove();
        $('#flip').remove();

        $('#image').append('<img src='+data.image+' id=featured />');
        $('#image').append('<img src='+data.reflection+' id=flip />');

        $('#featured').css('display','none');
        $('#flip').css('display', 'none');
        
        $('#flip').load(function(){$('#featured').fadeIn(2000);});
        $('#flip').load(function(){$(this).fadeIn(2000);});
        
        $('#image_name').text(data.title);
        $('.user').text(data.user);        
        
        $('#favorite_icon').text(data.favorite);
        
    }, "json");   
}

function favorite(element,id){
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
    $(clone).css('z-index',2);
    $(clone).css('vertical-align','middle');
    $(clone).css('top',  pos.top  - $(clone).height()/2  );
    $(clone).css('left', pos.left - $(clone).width()/2   );    
    $(clone).css('margin',0);
    $(clone).children(":first").removeAttr('onclick');
    
    $(clone).appendTo(grandparent);
    $(clone).children(":first").css('color','#666');    
    /*$(clone).css('opacity',1);*/
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