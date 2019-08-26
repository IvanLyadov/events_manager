<?php

	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
<?=$this->render('../_global_container.php')?>


<style media="screen">
	input {
		text-align: center !important;
	}
	#user-email {
		width: 220px !important;
	}
</style>

<div class="gl-container">
	<div class="content-box">
	<?php $form = ActiveForm::begin([
		 'id' => 'profile-data',
		 'options' => ['class' => ''],
		 'action' => $form_action,
	 ]) ?>

		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Profil
					</h2>
				</div>
			</div>
		</div>
		<div class="row">

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="profileimage">
					<span class="profilimage-item" style="background-image: url('<?= Url::to(['/uploads/user_files/'.$user->avatar_image], 'http') ?>');"></span>
					<div class="person-description">
						<span class="person-function">
							<?= $full_name ?>
						</span>
						<span class="person-page">
							<br>
						</span>
					</div>
					<div class="profile-file-info">
						<div>Maksymalna wielkość pliku: 2MB</div>
						<div>Rozszerzenie pliku: png, jpg</div>
						<?= $form->field($user, 'userFiles')->fileInput()->label('') ?>
						<div>Zdjęcie zostanie wyświetlone po zapisaniu profilu</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
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
						<td>TELEFON:</td>
						<td>
							<?= $form->field($user, 'phone')->textInput()->input('first_name', ['placeholder' => "",'class'=>''])->label('') ?>
						</td>
					</tr>
					<tr>
						<td>IMIĘ:</td>
						<td><?= $form->field($user, 'first_name')->textInput()->input('first_name', ['placeholder' => "",'class'=>''])->label('') ?></td>
					</tr>
					<tr>
						<td>NAZWISKO:</td>
						<td><?= $form->field($user, 'last_name')->textInput()->input('last_name', ['placeholder' => "",'class'=>''])->label('') ?></td>
					</tr>
					<tr>
						<td>EMAIL:</td>
						<td><?= $form->field($user, 'email')->textInput()->input('email', ['placeholder' => "",'class'=>''])->label('') ?></td>
					</tr>
					<tr>
						<td>O MNIE:</td>
						<td>
							<?= $form->field($user, 'description')->textarea(['description', ['placeholder' => "",'class'=>'']])->label('') ?>
						</td>
					</tr>
					<tr>
						<td>DOŚWIADCZENIE:</td>
						<td>
							<?= $form->field($user, 'experience')->textarea(['experience', ['placeholder' => "",'class'=>'']])->label('') ?>
						</td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td></td>
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
