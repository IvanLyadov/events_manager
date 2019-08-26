<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;

	$this->title = 'Log in';
?>
<?php if (Yii::$app->session->hasFlash('login_error')): ?>
  <div class="alert alert-danger alert-dismissable registration-alert">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i></h4>
  <?= Yii::$app->session->getFlash('login_error') ?>
  </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('reg_success')): ?>
  <div class="alert alert-success alert-dismissable registration-alert">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i></h4>
  <?= Yii::$app->session->getFlash('reg_success') ?>
  </div>
<?php endif; ?>

<div class="liginform-bg">
	<div class="form-wrapper">
		<div class="lgform-title">
			Resetowanie hasła użytkownika
		</div>
		<?php $form = ActiveForm::begin([
			 'id' => 'login-form',
			 'options' => ['class' => 'login-form'],
			 'action' => $action,
		 ]) ?>
			<?= $form->field($user_model, 'email')->textInput()->input('email', ['placeholder' => "E-mail",'class'=>'lgform-input'])->label('') ?>
			<p>
				<?= Html::submitButton('Wyślij', ['class' => 'login-btn btn btn-primary']) ?>
			</p>
			<p>
				<?= Html::a('Zaloguj', Url::to(['/login']), ['class' => 'login-btn btn btn-warning']) ?>
			</p>
		<?php ActiveForm::end() ?>
	</div>
</div>
