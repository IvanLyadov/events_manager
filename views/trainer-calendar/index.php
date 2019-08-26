<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
 <style media="screen">
 html, body{
	 overflow:hidden;
	 height: 100%;
 }
 .content-box_wrapper {
}
.global-container{
	height: 100%;
}
 </style>

<?=$this->render('../_global_container.php')?>

<div class="content-box_wrapper">
	<div class="content-box" style="overflow-y: scroll;     height: 100%">
		<div class="" style="margin:0px;padding:0px;height:100%;">
			<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
				<div class="dhx_cal_navline">
					<div class="dhx_cal_prev_button">&nbsp;</div>
					<div class="dhx_cal_next_button">&nbsp;</div>
					<div class="dhx_cal_today_button"></div>
					<div class="dhx_cal_date"></div>
					<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
					<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
					<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
				</div>
				<div class="dhx_cal_header">
				</div>
				<div class="dhx_cal_data">
				</div>
			</div>
		</div>

	</div>
</div>

<script>
	var urls = {};
	 urls.api = '<?= Url::to(['/trainer-calendar/load-events']) ?>';
	 urls.add_event = '<?= Url::to(['/trainer-calendar/calendar-add-event']) ?>';
	 urls.delete_event = '<?= Url::to(['/trainer-calendar/delete-event']) ?>';
	 urls.change_event = '<?= Url::to(['/trainer-calendar/change-event']) ?>';
	 var clients = '<?= $clients ?>';
</script>
<?php
	$this->registerJsFile(Url::base().'/js/trainer_calendar.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/hd-calendar/dhtmlxscheduler.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/hd-calendar/ext/dhtmlxscheduler_container_autoresize.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/hd-calendar/locale/locale_pl.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/hd-calendar/ext/dhtmlxscheduler_limit.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/js/syclicity-validator.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerJsFile(Url::base().'/js/drag-element.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	// $this->registerJsFile('/hd-calendar/ext/dhtmlxscheduler_collision.js', ['depends' => [yii\web\JqueryAsset::className()]]);
	$this->registerCssFile(Url::base().'/hd-calendar/skins/dhtmlxscheduler_material.css', ['depends' => [yii\web\JqueryAsset::className()]]);
 ?>
