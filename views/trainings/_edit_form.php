
<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use kartik\widgets\DepDrop;
 ?>

<?php $form = ActiveForm::begin([
	'id' => 'places-data',
	'options' => ['class' => ''],
	'action' => $action_url,
]) ?>


<!-- Default panel contents -->
<div class="panel-body">
	<h3 class="panel-title">Nazwa treningu</h3>
	<?= $form->field($trainings_model, 'title')->textarea(['title', ['placeholder' => "",'class'=>'']])->label('') ?>
</div>

<div class="panel-body">
	<h3 class="panel-title">Opis treningu</h3>
	<?= $form->field($trainings_model, 'description')->textarea(['description', ['description' => "",'class'=>'']])->label('') ?>
</div>



<div class="well panel-body time-range">
	<div id="datetimepicker0" class="input-append">
		<div class="btn-group" role="group" aria-label="...">

			<h3 class="panel-title" id="time-panel-title">Wybierz datę rozpoczęcia treningu</h3>
			<?php $trainings_model->training_date = date("d.m.Y", $trainings_model->start_ts); ?>
 			<?php
 				echo $form->field($trainings_model,'training_date')->widget(\yii\jui\DatePicker::className(),[
					'dateFormat'=> 'dd.MM.yyyy',
					'language' => 'pl',
					'model' => $trainings_model,
					'attribute' => 'training_date'
				])->label("")
			?>


		</div>
	</div>
</div>

<div class="well panel-body time-range">
	<div id="datetimepicker2" class="input-append">
		<div class="btn-group" role="group" aria-label="...">

			<h3 class="panel-title">Wybierz godziny rozpoczęcia i zakończenia treningu</h3>
			<label for="trainings-start_ts">Godzina rozpoczęcia treningu</label>
			 <?php
					 echo \janisto\timepicker\TimePicker::widget([
						    'language' => 'pl',
								'mode' => 'time',
								'options'=> ['id'=>'trainings-start_ts'],
								'name' => 'Trainings[start_ts]',
								'value' => date("G:i", $trainings_model->start_ts),
								'clientOptions' => [
										 'dateFormat' => 'yy-mm-dd',
										 'timeFormat' => 'HH:mm',
										 'showSecond' => false,
								 ]
						]);
				?>
				<label for="trainings-end_ts">Godzina zakończenia treningu</label>
				<?php
						echo \janisto\timepicker\TimePicker::widget([
								 'language' => 'pl',
								 'mode' => 'time',
								 'name' => 'Trainings[end_ts]',
								 'options'=> ['id'=>'trainings-end_ts'],
								 'value' => date("G:i", $trainings_model->end_ts),
								 'clientOptions' => [
											'dateFormat' => 'yy-mm-dd',
											'timeFormat' => 'HH:mm',
											'showSecond' => false,
									]
						 ]);
 					?>

		</div>
		<p id="post_error_training">Wybierz godziny rozpoczęcia i zakończenia treningu</p>
		<p id="error_time">Czas oraz data rozpoczęcia ma być wcześniejsza od daty zakończeia</p>
	</div>
</div>

<div class="content-box">
	<?= Html::submitButton('Zapisz', ['id' => 'post_btn_add_training', 'class' => 'btn btn-warning']) ?>
	<?= Html::a('Anuluj', $return_url,['class' => 'btn btn-success']) ?>
</div>



<?php ActiveForm::end() ?>
<script>
		var ajax_url = '<?= Url::to(["/trainings/check-traing-time-range"]) ?>'
</script>

<?php
	$this->registerJsFile(Url::base().'/js/trainings_form.js', ['depends' => [yii\web\JqueryAsset::className()]]);
 ?>
