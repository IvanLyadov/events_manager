<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use kartik\file\FileInput;
	use yii\data\Pagination;
	use yii\widgets\LinkPager;

 ?>

<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box ">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Dodanie, usuwanie plików
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav navbar-left" style="padding-left:">
						<li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Wstecz', $return_url , ['class' => '']) ?>
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
				<div class="navbar-left">
					Maksymalna wielkość pliku: 2MB, Dozwolone rozszerzenie pliku: png, jpg
				</div>
			</div>
		</div>

		<div class="row">
			
			<div class="col-xs-12 col-md-12 col-lg-12">
			<?php $form = ActiveForm::begin([
				 'id' => 'profile-data',
				 'options' => ['enctype' => 'multipart/form-data'],
				 'action' => $form_action,
			 ]) ?>


			<?php 
				// Usage with ActiveForm and model
				echo $form->field($users_images_model, 'imageFiles[]')->widget(FileInput::classname(), [
					'options' => ['multiple' => true, 'accept' => 'image/*'],
					'language' => 'pl',
					'pluginOptions'=>[
						'allowedFileExtensions'=>['jpg','png', 'jpeg'],
					],
				])
				->label('');
			 ?>

			<?php ActiveForm::end() ?>
			</div>
		</div>

		<div class="row">
			<?php $form = ActiveForm::begin([
				 'id' => 'places-data',
				 'options' => ['class' => ''],
				 'action' => $action_controller,
			 ]) ?>

			<div class="panel panel-default text-center">
				<div class="panel-heading " style="text-align:right;">
					<div class="dropdown">
						<?= Html::submitButton('Usuń', ['class' => 'btn btn-danger', 'name' => 'delete-event', 'disabled' => 'disabled' ]) ?>
					</div>
				</div>

				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="10%">
								Plik
							</th>
							<th width="80%">
								Nazwa pliku
							</th>
							<th width="10%">
								Zaznacz
							</th>

						</tr>
					</thead>
					<tbody>

						<?php foreach ($users_images_records as $users_images): ?>
						<tr>
							<td>
								<div class="icon-tmpl" style="background-image: url(<?= Url::to(['/uploads/gallery/' . $users_images->image], 'http') ?>);"></div>
							</td>
							<td class="text-left">
								<?= $users_images->image ?>
							</td>
							<td>
								<div class="dropdown ">
									<input type="checkbox" name="images_checked[<?= $users_images->id ?>]" value="<?= $users_images->id ?>">
								</div>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>

			<?php ActiveForm::end() ?>
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
	jQuery(document).ready(function($) {
		$(document).on('click', 'button[name="delete-event"]', function(event) {
				var confirmCheck = confirm("Czy na pewno chcesz usunąć?");
				if (confirmCheck) {
					return true;
				}else{
					event.preventDefault();
				}
			});

			var enabled = false;
			$(document).on('change', 'input[type="checkbox"]', function() {
				var n = $( "input:checked" ).length;
				if (n == 0 && enabled == true) {
					$('button[name="delete-event"]').attr({ disabled : "disabled" });
					$('select[name="group-name"]').attr({ disabled : "disabled" });
					enabled = false;
				}else{
					$('button[name="delete-event"]').removeAttr("disabled");
					$('select[name="group-name"]').removeAttr("disabled");
					enabled = true;
				}
			});

			$(document).on('change', 'select[name="group-name"]', function(){
				if ( $(this).val() != 0 ) {
					$("#group-lable").slideUp("fast");
				}
			})

	});
JS;
$this->registerJs($script);
?>
