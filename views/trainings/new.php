<?php
	use app\helpers\PlacesHelper;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;

 ?>
<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-md-offset-2 col-lg-offset-2">
				<div class="title-section">
					<h2>
						Dodaj trening
					</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="panel panel-default">
				<div class="col-xs-12 col-md-7 col-lg-7 col-md-offset-2 col-lg-offset-2">
					<?= $this->render('_form.php', $trainings) ?>
				</div>
			</div>
		</div>

	</div>

</div>
