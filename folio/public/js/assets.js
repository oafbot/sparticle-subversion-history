$(document).ready(function(){
    "use strict";

    $.preload( '#items img', {		
        placeholder: root_url+'/images/placeholderM.png',		
		threshold: 2
        //notFound:
	});

    $("#pop-up").dialog({
        modal: true,
        autoOpen: false,
        show: "blind",
        hide: "fade",
        resizable: false,
        position:[pageWidth()*0.5-150,pageHeight()*0.2],
        title: '<span class="webfont popup">&#87;</span> &nbsp; Delete Media?'
    });

    $("#delete").click(function(e){
        e.preventDefault();
        var submitButton = e.target;
        
        $("#pop-up").dialog('option', 'buttons', {
                "Delete" : function() {
                    var input = $("<input>").attr("type", "hidden").attr("name", "action").val("Delete");
                    $('form').append($(input));                    
                    $('form').submit();
                    },
                "Cancel" : function() {
                    $(this).dialog("close");
                    }
                });

        $("#pop-up").dialog("open");

    });
});

function toggle_selection(id){
    var image    = document.getElementById('image'+id);
    var checkbox = document.getElementById('checkbox'+id);
    var name     = document.getElementById('name'+id);
    
    if(image.className == "unselected"){
        image.className = "selected";
        checkbox.checked = true;
        name.className = "h3-selected";
    }        
    else{
        image.className = "unselected";
        checkbox.checked = false;
        name.className = "h3-unselected";
    }
}