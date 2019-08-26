<?php
	use app\helpers\PlacesHelper;
	use yii\helpers\Html;
	use yii\helpers\Url;

 ?>
<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Notatki
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">

					</div>


					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

					  <ul class="nav navbar-nav navbar-right">
					  <li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Wstecz', $return_url , ['class' => '']) ?>
							</div>
						</li>
						<li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Dodaj notatke', $add_note_url , ['class' => '']) ?>
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
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-heading">Lista notatek dla treningu: <?php if ($trainings->title): echo print_r($trainings->title); endif ?></div>
					<div class="">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="30%">
										Nazwa
									</th>
									<th width="40%">
										Opis
									</th>
									<th width="16%">
										Utworzono
									</th>

									<th width="14%">
										Opcje
									</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($trainings_notes as $trainings_note): ?>
								<tr>
									<td>
										<?= $trainings_note->title ?>
									</td>
									<td>
										<?= $trainings_note->description ?>
									</td>
									<td>
										<?= date("d.m.Y", $trainings_note->created_ts) ?>
									</td>


									<td>
										<div class="dropdown ">
											<button class="btn btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												Opcje
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
												<li>
													<?=  Html::a('Edytuj', $edit_note_url.'&id='.$trainings_note->id,['class' => '']) ?>
												</li>
												<li>
													<?=  Html::a('Usuń', $delete_note_url.'&id='.$trainings_note->id,['class' => '']) ?>
												</li>

											</ul>
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
	</div>

</div>
