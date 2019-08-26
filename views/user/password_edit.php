<?php

	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
<?=$this->render('../_global_container.php')?>


<div class="gl-container">
	<div class="content-box">
	<?php $form = ActiveForm::begin([
		 'id' => 'profile-data',
		 'options' => ['class' => ''],
		 'action' => $form_action,
	 ]) ?>

		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-md-offset-2 col-lg-offset-2">
				<div class="title-section">
					<h2>
						Edytuj Hasło
					</h2>
				</div>
			</div>
		</div>
		<div class="row">

			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-md-offset-2 col-lg-offset-2">
				<table class="table borderless text-left profile-table">
					<thead>
						<tr>
							<th width="8%">

							</th>
							<th width="12.5%">

							</th>
						</tr>
					</thead>
					<tr>
						<td>
							<?= $form->field($user, 'password')->textInput()->input('password', ['placeholder' => "",'class'=>'form-control'])->label('Obecne hasło') ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $form->field($user, 'passwordChange')->textInput()->input('password', ['placeholder' => "",'class'=>'form-control'])->label('Nowe hasło:') ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $form->field($user, 'passwordRepeat')->textInput()->input('password', ['placeholder' => "",'class'=>'form-control'])->label('Powtórz nowe hasło:') ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= Html::submitButton('Zapisz', ['class' => 'btn btn-warning']) ?>
							<?= Html::a('Anuluj', $return_url,['class' => 'btn btn-success']) ?>
						</td>
					</tr>
				</table>
				<?php ActiveForm::end() ?>
			</div>
		</div>
	</div>
</div>
