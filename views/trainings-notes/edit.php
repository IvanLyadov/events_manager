<?php
	use app\helpers\PlacesHelper;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
<?=$this->render('../_global_container.php')?>

<style>
	.see_client{
		display: inline-block;
	}
</style>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-md-offset-2 col-lg-offset-2">
				<div class="title-section">
					<h2>
						Dodaj notatkę
					</h2>
				</div>
			</div>
		</div>
		<?php $form = ActiveForm::begin([
			 'id' => 'places-data',
			 'options' => ['class' => ''],
			 'action' => $action_url,
		 ]) ?>

		<div class="row">
			<div class="panel panel-default">
				<div class="col-xs-12 col-md-7 col-lg-7 col-md-offset-2 col-lg-offset-2">
					<div class="panel-body">
						<h3 class="panel-title">Nazwa notatki</h3>
						<?= $form->field($trainings_notes_model, 'title')->textarea(['title', ['placeholder' => "",'class'=>'']])->label('') ?>
					</div>

					<div class="panel-body">
						<h3 class="panel-title">Opis</h3>
						 <?= $form->field($trainings_notes_model, 'description')->textarea(['description', ['description' => "",'class'=>'']])->label('') ?>
						 <?= $form->field($trainings_notes_model, 'created_ts')->hiddenInput(['description', ['description' => "",'class'=>'']])->label(false);?>
					</div>

					<div class="panel-body">
						<h3 class="panel-title see_client">Widoczne dla klienta:</h3>
						<?= $form->field($trainings_notes_model, 'public')->checkbox(['label'=>''])->label(false) ?>
					</div>


				</div>
			</div>
		</div>

		<?= Html::submitButton('Zapisz', ['class' => 'btn btn-warning']) ?>
		<?= Html::a('Anuluj', $return_url,['class' => 'btn btn-success']) ?>

		<?php ActiveForm::end() ?>

	</div>

</div>
