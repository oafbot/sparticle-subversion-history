//comment.js

function focus_comment(){
    $('#comment').animate({
        height: 100}, 500);
}

function unfocus_comment(){
    $('#comment').animate({
        height: 40}, 500);
}

function add_comment(){
    
     $("#comment_form").submit(function(event) {

        /* stop form from submitting normally */
        //event.preventDefault(); 
        
        if(!$.trim($("#comment").val()).length){
            laika_alert('Comment is empty!','warning');
        }
        else{
            var usr = $("#comment_form").find( 'input[name="user"]' ).val();
            var type = $("#comment_form").find( 'input[name="parent_type"]' ).val();
            var id = $("#comment_form").find( 'input[name="parent_id"]' ).val();
            
            /* jQuery really makes AJAX more convoluted than it needs to be... */
            
            $.get(root_url+'/api/avatar?user='+usr+'&size=50', function(avatar){
                
                $.post(root_url+'/comment/add', 
                    { comment: $("#comment").val(), user: usr, parent_type: type, parent_id: id },            
                
                    function(data) {                    
                        $('#thread').prepend(
                            '<div class="comment_box_js">'+avatar+
                            '<img src="'+root_url+'/images/pointer.png" class="pointer"/>'+
                            '<p class="comment_bubble">'+data.new_comment+
                            '</p><div class="comment_info">'+data.user_link+
                            '<br />Posted just now...</div><br /></div>'
                            );
                        $("#comment").val("");                
                    }, "json" );
                
            }); //end get
        } //end else
    });
    
}

function delete_comment(id){
    
    $('#pop-up').dialog({ 
        modal: true, 
        show: "blind",
        hide: "fade",
        resizable: false,
        position:[pageWidth()*0.5-150,pageHeight()*0.2],
        title: '<span class="webfont popup">&#87;</span> &nbsp; Delete Comment?',
        buttons: {
				"Delete": function() {
					$( this ).dialog( "close" );
					laika_alert('Comment deleted','success');
                    $('#'+id).animate({
                        opacity: 0.1
                    }, 800, function() {
                        $('#'+id).slideUp(500,function(){$('#'+id).remove();});
                    });
                    $( this ).dialog( "close" );
                    $.post(root_url+'/comment/delete', {id: id} );
				},
				"Cancel": function(){
				    $( this ).dialog( "close" );
				}
        }});
}