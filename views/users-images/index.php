<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use app\helpers\LightboxHelper;
	use yii\widgets\LinkPager;

 ?>

<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box ">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Galeria
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav navbar-left">
						<li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Edytuj', $add_url , ['class' => '']) ?>
							</div>
						</li>
					  </ul>
					</div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>

		<div class="row">

			<div class="col-xs-12 col-md-12 col-lg-12">
				<?php foreach ($trainer_images as $trainer_image): ?>
					<?php
						echo LightboxHelper::widget([
							'files' => [
								[
									'thumb' => Url::to(['/uploads/gallery/' . $trainer_image->image], 'http'),
									'original' => Url::to(['/uploads/gallery/' . $trainer_image->image], 'http'),
									// 'title' => 'optional title',
									'group' => 'ligtbox',
									'img-class' => 'gallery-thumbnail',
									'linkOptions' => ['class' => 'thumbnail gallary-link'],
								],
							]
						]);
					?>
				<?php endforeach ?>

			</div>
				<?php
				// display pagination
				echo LinkPager::widget([
					'pagination' => $pagination,
				]);
				?>
		</div>
	</div>

</div>

<?php
$script = <<< JS

JS;
$this->registerJs($script);
?>
