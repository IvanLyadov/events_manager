<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
 ?>

<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">

		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="pull-left" style="padding: 10px 0px">
					<a class="btn btn-primary" href="<?php echo Url::to(['user-tasks/new']) ?>">Dodaj nowe zadanie</a>
				</div>
				<div class="pull-left" style="padding: 10px 0px; margin-left:10px;">
					<a class="btn btn-primary" href="<?php echo Url::to(['trainings/show-tasks-list']) ?>">Wszystkie zadania</a>
				</div>
				<div style="clear: both"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div>
					<div class="panel panel-default" id="selected-day-tasks-list">
						<?php echo $this->render("/user-tasks/_selected-day-list",[
							'selectedDayTime' => $selectedDayTime,
							'user_tasks' => $user_tasks_selected_day,
						]) ?>
					</div>
				</div>
			</div>


			<div class="col-md-4 col-lg-4">
				<div class="taks-calendar"></div>
				<div class="box"></div>
			</div>
		</div>
	</div>
</div>

<script>
	var selectedDayTime=<?=$selectedDayTime ?>;
	if(sessionStorage.getItem('selectedTaskDaytime')){
        selectedDayTime=sessionStorage.getItem('selectedTaskDaytime');
	}
    // calendar inicialization
	var dataCalendar = JSON.parse( '<?php echo $json_calendar; ?>' );

	document.addEventListener("DOMContentLoaded", function(event) {
		$('.taks-calendar').pignoseCalendar({
			lang: 'pl',
			week: 1,
			theme: 'blue',
			scheduleOptions: {
				colors: {
					event: '#2fabb7',
					ad: '#5c6270',
				}
			},
			schedules: dataCalendar,
			date: moment.unix(selectedDayTime),
			// select: createTaskTable,
			select: function (date, context) {
								if (context.storage.schedules.length != 0) {
									$.ajax({
										url: '<?php echo Url::to(['/trainings/get-user-tasks']); ?>',
										type: 'POST',
										// dataType: 'json',
										data: {
													time: new Date(context.storage.schedules[0].date).getTime() / 1000
										},
									})
									.done(function(data) {
										$('#selected-day-tasks-list').html(data);
										console.log(data);
									})
									.fail(function(data) {
										console.log("fail");
									})
								}
            },
		});
	});

</script>

<?php
	$this->registerJsFile('/js/task-calendar.js', ['depends' => [yii\web\JqueryAsset::className()]]);
 ?>
