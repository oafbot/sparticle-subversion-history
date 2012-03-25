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