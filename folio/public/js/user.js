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