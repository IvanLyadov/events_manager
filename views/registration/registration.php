<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	$this->title = 'Zarejestuj się';

 ?>

<?php $form = ActiveForm::begin([
	 'id' => 'login-form',
	 'options' => ['class' => 'form-registration'],
	 // 'enableAjaxValidation' => true,
 ]) ?>

 <?php if (Yii::$app->session->hasFlash('error')): ?>
   <div class="alert alert-danger alert-dismissable registration-alert">
   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
   <h4><i class="icon fa fa-check"></i></h4>
   <?= Yii::$app->session->getFlash('error') ?>
   </div>
 <?php endif; ?>

<div class="liginform-bg">
	<div class="form-wrapper">
		<div class="lgform-title">
			Rejestracja Trenera
		</div>
		<form>
			<div class="lgform-input-wr-">
				<?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "E-mail",'class'=>'lgform-input'])->label('') ?>
				<?= $form->field($model, 'first_name')->textInput()->input('first_name', ['placeholder' => "Imię",'class'=>'lgform-input'])->label('') ?>
				<?= $form->field($model, 'last_name')->textInput()->input('last_name', ['placeholder' => "Nazwisko",'class'=>'lgform-input'])->label('') ?>
				<?= $form->field($model, 'phone')->textInput()->input('phone', ['placeholder' => "Telefon (9 cyfr)",'class'=>'lgform-input', 'type' => 'tel', 'minlength'=> '9'])->label('') ?>

				<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Hasło (min. 8 znaków)", 'class'=> 'lgform-input', 'minlength'=> '8'])->label('') ?>
				<?= $form->field($model, 'passwordConfirm')->passwordInput()->input('passwordConfirm', ['type' => 'password','placeholder' => "Powtórz hasło", 'class'=> 'lgform-input'])->label('')?>
			</div>

			<span class="rem-lg">
				<label class="recall-check " for="recall"></label>
				<span class="recall-desc">Wyrażam zgodę na gromadzenie i przetwarzanie podanych wyżej moich danych osobowych przez administratora serwisu, tj. Spółkę TDS Sp. z o.o. w celu realizacji</span>
				<input type="checkbox" name="recall" id="recall" class="recall-input" oninvalid="this.setCustomValidity('W celu rejestracji należy wyrazić zgodę na przetwarzanie danych.')" oninput="setCustomValidity('')" required>
			</span>

			<span class="rem-lg">
				<label class="recall-check " for="recall-2"></label>
				<span class="recall-desc">Akceptuję <a href="#">regulamin</a> i <a href="#">politykę prywatności</a></span>
				<input type="checkbox" name="recall-2" id="recall-2" class="recall-input" oninvalid="this.setCustomValidity('W celu rejestracji należy zaakceptować regulamin.')" oninput="setCustomValidity('')" required>
			</span>

			<span class="rem-lg">
				<label class="recall-check " for="recall-3"></label>
				<span class="recall-desc">Oświadczam także, że zapoznałem się z przysługującymi mi uprawnieniami w zakresie możliwości wglądu do gromadzonych danych oraz o możliwości ich uzupełnienia, uaktualnienia oraz żądania sprostowania w razie stwierdzenia, że dane te są niekompletne, nieaktualne lub nieprawdziwe.</span>
				<input type="checkbox" name="recall-3" id="recall-3" class="recall-input" oninvalid="this.setCustomValidity('W celu rejestracji należy zapoznać się z uprawnieniami.')" oninput="setCustomValidity('')" required>
			</span>

			<p>
				<?= Html::submitButton('Zarejestruj się', ['class' => 'login-btn btn btn-primary']) ?>
			</p>
			<a href="login" class="login-btn btn btn-success">
				Zaloguj się
			</a>
			<?php ActiveForm::end() ?>
		</form>
	</div>
</div>
