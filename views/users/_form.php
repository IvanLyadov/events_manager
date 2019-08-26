
<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
 ?>


<!-- Default panel contents -->
<div class="content-box">
	<?php $form = ActiveForm::begin([
		 'id' => 'places-data',
		 'options' => ['class' => ''],
		 'action' => $action_url,
	 ]) ?>
	<div class="panel-body">
		<h3 class="panel-title">E-mail</h3>
		<?= $form->field($user_model, 'email')->textarea(['email', ['placeholder' => "",'class'=>'']])->label('') ?>
	</div>

	<div class="panel-body">
		<h3 class="panel-title">Imię</h3>
		 <?= $form->field($user_model, 'first_name')->textarea(['first_name', ['description' => "",'class'=>'']])->label('') ?>
	</div>

	<div class="panel-body">
		<h3 class="panel-title">Nazwisko</h3>
		 <?= $form->field($user_model, 'last_name')->textarea(['last_name', ['description' => "",'class'=>'']])->label('') ?>
	</div>

	<div class="panel-body">
		<h3 class="panel-title">Telefon</h3>
		 <?= $form->field($user_model, 'phone')->textarea(['phone', 'placeholder'=> 'np. 123 456 789', ['description' => "",'class'=>'',]])->label('') ?>
	</div>


	<?= Html::submitButton('Zapisz', ['class' => 'btn btn-warning']) ?>
	<?= Html::a('Anuluj', $return_url,['class' => 'btn btn-success']) ?>

	<?php ActiveForm::end() ?>