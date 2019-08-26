<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Dodaj nowe zadanie
					</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<?php echo $this->render("_form",[
						"userTask" => $userTask,
						"action" => $action,
						"back_url" => $back_url,
					]) ?>
			</div>
		</div>
	</div>
</div>
