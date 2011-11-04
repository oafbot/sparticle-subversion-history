$(function(){
$('#upload').MultiFile({
list: '#upload-list',
STRING: {remove: '<img src="../images/icons/delete.png" alt="x"/>' },
//onFileSelect: function(element, value, master_element){$('#file_selected').val(value);}
//onFileRemove: function(element, value, master_element){$('MultiFile-label').fadeOut(500);}
});
});