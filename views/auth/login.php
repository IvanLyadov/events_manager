<?php

/* @var $this yii\web\View */
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;

	$this->title = '';
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
			Log in
		</div>
		<?php $form = ActiveForm::begin([
			 'id' => 'login-form',
			 'options' => ['class' => 'login-form'],
			 'action' =>['index.php/auth/login-submit'],
		 ]) ?>
		<form>
			<?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "E-mail",'class'=>'lgform-input'])->label('') ?>
			<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Hasło", 'class'=> 'lgform-input'])->label('') ?>
			<?= Html::submitButton('Zaloguj', ['class' => 'login-btn btn btn-success']) ?>
			</form>
		<div class="remember-link">
			<?= Html::a('Przypomnij hasło', Url::to(['/reset_password']), ['class' => 'login-btn btn btn-warning']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>
