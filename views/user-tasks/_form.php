<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
	'id' => 'user-task-form',
	'options' => [
		'class' => '',
	],
	'fieldConfig' => [
		'template' => "{input}\n{hint}\n{error}",
		'options' => [
			'class' => NULL,
		],
	],
	'action' => $action,
	'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
]) ?>

<?php echo $form->field($userTask, 'id')->hiddenInput() ?>
<?php echo $form->field($userTask, 'title')->textInput(['placeholder' => 'Tytuł']) ?>
<?php echo $form->field($userTask, 'description')->textArea([
	'placeholder' => 'Opis',
	'style' => 'resize: none; min-height: 250px',
]) ?>
<?php echo $form->field($userTask, 'selectedDay')->textInput([
	'placeholder' => 'Wybierz dzień',
	'style' => "cursor:pointer"
]) ?>
<input type="hidden" name="module_url" value="<?= $back_url ?>">


<div class="content-box">
	<?php echo Html::submitButton('Zapisz', ['class' => 'btn btn-success']) ?>
	<?php echo Html::a('Anuluj', $back_url, ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>

<?php

$selectedDayId = Html::getInputId($userTask, 'selectedDay');
$dateFormat = $userTask::DATE_FORMAT;

$pignoseCalendarJs = <<<pignoseCalendarJs

$('#$selectedDayId').pignoseCalendar({
	theme: 'blue', // light, dark, blue
	lang: 'pl',
	format: "$dateFormat",
	week: 1,
});

pignoseCalendarJs;

$this->registerJs($pignoseCalendarJs, \yii\web\View::POS_END, 'pignoseCalendarJs'); 

?>
