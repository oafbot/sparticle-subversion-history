/*
jQuery(function( $ ){
    $.preload( '#fullscreen_content img', {		
        placeholder: root_url+'/images/placeholder.png',		
		threshold: 5 
	});
});
*/

function clickFlash(element){
    var pos = $(element).position();

    var clone = $(element).children(":first").clone();
    var parent = element;
    var grandparent = $(parent).parent();    
    
    var left = $(element).marginLeft;
    var top  = $(element).marginTop;
    var size =  parseFloat($(element).children(":first").css('font-size'));
        
    $(clone).css('position','absolute');
    $(clone).css('z-index',11);
    $(clone).css('vertical-align','middle');
    $(clone).css('top',  pos.top  - $(clone).height()*0.6 );
    $(clone).css('left', pos.left - $(clone).width()*0.5  );    
    $(clone).css('margin',0);
    $(clone).removeAttr('onclick');
    
    $(clone).appendTo(parent);
    $(clone).css('color','#666');    
    $(clone).animate({
        fontSize: size*3,
        opacity:0.3,
        top:  pos.top  - $(clone).height()*0.6,
        left: pos.left - $(clone).width()*0.5,
        marginTop:  -$(clone).height()*0.6,
        marginLeft: -$(clone).width()*0.5
    },1000,
        function(){
            $(clone).fadeOut(500,function(){$(clone).remove()});
        });    
}