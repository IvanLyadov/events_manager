<?php
	use app\helpers\PlacesHelper;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-md-offset-2 col-lg-offset-2">
				<div class="title-section">
					<h2>
						Wyślij e-mail
					</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="panel panel-default">
				<div class="col-xs-12 col-md-7 col-lg-7 col-md-offset-2 col-lg-offset-2">

					<?php $form = ActiveForm::begin([
						 'id' => 'places-data',
						 'options' => ['class' => ''],
						 'action' => $action_url,
					 ]) ?>
					<!-- Default panel contents -->
					<div class="panel-body">
						<h3 class="panel-title">Temat</h3>
						<textarea name="title" id="title" class="form-control"></textarea>
					</div>

					<div class="panel-body">
						<h3 class="panel-title">Wiadomość</h3>
						<textarea name="message" id="message" class="form-control"></textarea>
					</div>


					<?= Html::submitButton('Wyślij', ['class' => 'btn btn-warning']) ?>
					<?= Html::a('Anuluj', $return_url,['class' => 'btn btn-success']) ?>

					<?php ActiveForm::end() ?>
				</div>
			</div>
		</div>

	</div>

</div>
