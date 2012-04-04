/*
$(function(){
$('#upload').MultiFile({
    list: '#upload-list',
    string: {remove: '<img src="'+root_url+'/images/icons/delete.png" alt="x"/>' },
    onFileSelect: function(element, value, master_element){ $('#file_selected').val(value); },
    onFileRemove: function(element, value, master_element){ $('MultiFile-label').fadeOut(500); }
    });
});
*/

jQuery(function($){
$('#upload').MultiFile({
    string: {remove: '<img src="images/icons/delete.png" alt="&#45;" class="webfont"/>' },
    list: '#upload-list'
    });
});