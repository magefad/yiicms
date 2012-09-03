/**
 * User: fad
 * Date: 18.07.12
 * Time: 15:26
 */
function ajaxSetStatus(elem, id){
	$.ajax({
		url: $(elem).attr('href'),
		success: function(){
			$('#'+id).yiiGridView.update(id);
		}
	});
}

function ajaxSetSort(elem, id){
	$.ajax({
		url: $(elem).attr('href'),
		success: function(){
			$('#'+id).yiiGridView.update(id);
		}
	});
}