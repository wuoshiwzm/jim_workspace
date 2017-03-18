$(document).ready(function() {
	var dataIdArr9 = new Array();//access4000x
	$('.rt-data').each(function() {
		if ($(this).attr('data_type') == 'liebert' && dataIdArr9.indexOf($(this).attr('data_id')) == -1) {
			dataIdArr9.push($(this).attr('data_id'));
		}
	});
	function refreshData() {
		$.get('/portal/refreshData', {
			dataIdArr9 : dataIdArr9.toString(),
			model : model,
			access_token : typeof(accessToken) == "undefined" ? "" : accessToken
		}, function(ret) {	
			for(var i = 0 ; i < ret.libertPexList.length ; i++)
			{
				var obj = ret.libertPexList[i];
				for(var j = 0 ; j < obj.value.length ; j++)
				{					
					$('#liebert-' + obj.data_id + '-field' + j ).html(obj.value[j]);
					//$('#access4000x-' + obj.data_id + '-field' + j +' span:eq(0)').attr('class',cls);
				}
			}
		});
	}
	refreshData();
	setInterval(refreshData, 20000);
});