<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>

<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box ">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Klienci
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					  <ul class="nav navbar-nav navbar-right">
						<li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Dodaj klienta', $add_url , ['class' => '']) ?>
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
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="investment-name" width="16%">
								Imię
							</th>
							<th width="16%">
								Nazwisko
							</th>
							<th width="16%">
								E-mail
							</th>
							<th width="16%">
								Telefon
							</th>
							<th width="36%">
								Opcje
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $user): ?>
						<tr>
							<td>
								<?= $user->first_name ?>
							</td>
							<td>
								<?= $user->last_name ?>
							</td>

							<td>
								<?= $user->email ?>
							</td>
							<td>
								<?= $user->phone ?>
							</td>

							<td>
								<div class="dropdown ">
									<?= Html::a('Wyślij email', $sendemail_url.'?user_id='.$user->id,['class' => 'btn btn-primary']) ?>
									<?= Html::a('Pokaż treningi', $trainings_url.'?id_user='.$user->id,['class' => 'btn btn-success']) ?>
									<?= Html::a('Dodaj trening', $add_training.'?id_user='.$user->id,['class' => 'btn btn-success']) ?>
									<?= Html::a('Usuń klienta', $delete_client.'?id='.$user->id,['class' => 'btn btn-danger', 'id' => "delete-client"]) ?>
								</div>
								<div class="clearfix"></div>
							</td>

						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<?php
$script = <<< JS
	jQuery(document).ready(function($) {
		$(document).on('click', '#delete-client', function(event) {
				var confirmCheck = confirm("Czy na pewno chcesz usunąć klienta z listy?");
				if (confirmCheck) {
					return true;
				}else{
					event.preventDefault();
				}
			});
	});
JS;
$this->registerJs($script);
?>
