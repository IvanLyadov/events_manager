$.timepicker.datetimeRange(
	// startDateTextBox,
	// endDateTextBox,
	{
		minInterval: (1000*60*60), // 1hr
		dateFormat: 'dd M yy',
		timeFormat: 'HH:mm',
		start: {}, // start picker options
		end: {} // end picker options
	}
);



	function sendAjax(url, data, callBack){
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
		})
		.done(function(data) {
			if(callBack){
				callBack(data);
			}
		})
	}

	var validation = {
		calendar: false,
		time: false
	};
	document.getElementById("post_btn_add_training").addEventListener("click", function(event){
		event.preventDefault();
		if ($('#trainings-training_date').val() == "") {
			$('#time-panel-title').css("color",'red');
		}

		if ($('#trainings-training_date').val() == "") {

			validation.calendar = false;
			anableDisableButton();
		}else{

			validation.calendar = true;
			anableDisableButton();
		}


		if (document.getElementById("trainings-start_ts").value == "" || document.getElementById("trainings-end_ts").value == "")
		{
			event.preventDefault();
			document.getElementById("post_error_training").style.display = "block";
			$('#post_btn_add_training').attr('disabled', true);
		}else{
			document.getElementById("post_error_training").style.display = "none";
			$('#post_btn_add_training').attr('disabled', false);

			var trainingsStart_ts = $('#trainings-start_ts').val();
			var trainingsEnd_ts = $('#trainings-end_ts').val();
			var trainingsTraining_date = $('#trainings-training_date').val();

			var res = trainingsTraining_date.split('.');
			res.reverse();
			var trainingsDate = res.join('.');

			trainingsEnd_ts =  trainingsDate + " " + trainingsEnd_ts;
			trainingsStart_ts =  trainingsDate + " " + trainingsStart_ts;

			sendAjax(ajax_url, {start_ts: new Date(trainingsEnd_ts).getTime() / 1000 , end_ts: new Date(trainingsStart_ts).getTime() / 1000}, function(data){
					var dataAvailability = JSON.parse(data);
					var availabilityControll = 'Wybrany termin nie obejmuje czas wolny trenera';
					if (dataAvailability.availability == true) {
						availabilityControll = 'Wybrany termin obejmuje czas wolny trenera';
					}
					if (dataAvailability.trainings == true) {
						if (confirm('W wybranym okresie istnieje już trening. Czy dodać kolejny? ' + availabilityControll)) {
							$('#places-data').submit();
						}
					}else{
						$('#places-data').submit();
					}
			});

		}
	});

	$('#trainings-training_date, #trainings-start_ts, #trainings-end_ts').on('change', function(){
		if ($('#trainings-training_date').val() == "") {
			validation.calendar = false;
			anableDisableButton();
		}else{

			validation.calendar = true;
			anableDisableButton();
		}

		var start_ts = $('#trainings-start_ts').val().replace(':', '.');
		var end_ts = $('#trainings-end_ts').val().replace(':', '.');
		if (start_ts.length == 0 || parseFloat(start_ts) >= parseFloat(end_ts) ) {
			validation.time = false;
			anableDisableButton();
		}else{
			validation.time = true;
			anableDisableButton();
		}


	})


    function anableDisableButton(){
		if (validation.calendar) {
			$('#time-panel-title').css("color",'inherit');
		}else{
			$('#time-panel-title').css("color",'red');

		}

		if (validation.time) {
			$('#error_time').removeClass('error_time_active');
			$("#post_error_training").css('display', "none");
		}else{
			$('#error_time').addClass('error_time_active')
			$("#post_error_training").css('display', "block");
		}
		if (validation.time && validation.calendar) {
			$('#post_btn_add_training').attr('disabled', false);
		}else{
			$('#post_btn_add_training').attr('disabled', true);
		}


    }
