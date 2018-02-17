// JavaScript Document
function checkTimer(page_name){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/get_timer_info.php',
		type: 'POST',
		data: {
			page_name: page_name	
		},
		
		success: function(data) {
			retObj=JSON.parse(JSON.stringify(data));		
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(jqXHR+"123");
		},
		dataType: "json",
		async: false
	});
	return retObj;
}

function showTimer(page_start_time, page_end_time, current_time, time_left_id, progress_bar_class){
	var flag_time=true;
	var timer=setInterval(function(){
		if(flag_time){
			var server_time= new Date(current_time);
		}
		else{
			var server_time= new Date();
		}
		var start_time= new Date(page_start_time);
		var end_time= new Date(page_end_time);
		if((start_time.getTime()- server_time.getTime()) > 0){
			//Request Denied
			$('#timer_div .info-box-text').html("REQUEST WILL BE ACCEPTED AFTER");
			var diff=start_time.getTime() - server_time.getTime();
			var diffSeconds = Math.floor(diff / 1000 % 60);         
			var diffMinutes = Math.floor(diff / (60 * 1000) %60);         
			var diffHours = Math.floor(diff / (60 * 60 * 1000) % 24); 
			var diffDays = Math.floor(diff / (60 * 60 * 1000 * 24));
			$("#"+time_left_id).html("Days: "+diffDays+", "+diffHours+":"+diffMinutes
			+":"+diffSeconds);
			$('.'+progress_bar_class).css('width','0%');
			$('#pageModal').modal('hide');
			$('#page_content').hide();
		}
		else{
			var diff= end_time.getTime() - server_time.getTime();
			if(diff < 0){
				$('#timer_div .info-box-text').html("TIME EXPIRED");
				$('#pageModal').modal('hide');
				$('#page_content').hide();
				$("#"+time_left_id).empty();
				$('.'+progress_bar_class).css('width','100%');
				clearInterval(timer);
			}
			else{
				$('#page_content').show();
				$('#timer_div .info-box-text').html("TIME REMAINING");
				var diffSeconds = Math.floor(diff / 1000 % 60);         
				var diffMinutes = Math.floor(diff / (60 * 1000) %60);         
				var diffHours = Math.floor(diff / (60 * 60 * 1000) % 24); 
				var diffDays = Math.floor(diff / (60 * 60 * 1000 * 24));
				$("#"+time_left_id).html("Days: "+diffDays+", "+diffHours+":"+diffMinutes
				+":"+diffSeconds);
				var prog=100-Math.floor(diff/(end_time.getTime()-start_time.getTime())*100);
				//alert(diff/(end_time.getTime()-start_time.getTime()));
				$('.'+progress_bar_class).css('width',prog+'%');
			}
		}
		flag_time=false;
	},1000);
}