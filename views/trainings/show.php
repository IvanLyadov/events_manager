<?php
	use app\helpers\PlacesHelper;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;

 ?>
<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Treningi
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

					  <ul class="nav navbar-nav navbar-left">
					  <li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Wstecz', $get_back_url , ['class' => '']) ?>
							</div>
						</li>
						<li class="pd-elem">
							<div type="button" class="btn btn-default">
								<?= Html::a('Dodaj trening', $add_url , ['class' => '']) ?>
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
					<div class="panel-heading">Lista treningów przypisanych do użytkownika: <?= $user_name->first_name.' '.$user_name->last_name ?></div>
					<div class="">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="20%">
										Nazwa
									</th>
									<th width="20%">
										Opis
									</th>
									<th width="20%">
										Zaczyna się
									</th>
									<th width="20%">
										Kończy się
									</th>
									<th width="13%">
										Opcje
									</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($trainings as $training): ?>
								<tr>
									<td>
										<?= $training->title ?>
									</td>
									<td>
										<?= $training->description ?>
									</td>
									<td>
										<?php if ($training->start_ts): ?>
											<?= date('d-m-Y H:i', $training->start_ts) ?>
										<?php endif ?>
									</td>
									<td>
										<?php if ($training->end_ts): ?>
											<?= date('d-m-Y H:i', $training->end_ts) ?>
										<?php endif ?>
									</td>
									<td>
										<div class="dropdown ">
											<button class="btn btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												Opcje
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
												<li>
													<?=  Html::a('Edytuj', $edit_url.'&id='.$training->id,['class' => '']) ?>
												</li>
												<li>
													<?= Html::a('Usuń', $delete_url.'&id='.$training->id,['class' => "delete-link"]) ?>
												</li>
												<li>
													<?=  Html::a('Dodaj notatke', $add_note_url.'&id='.$training->id,['class' => '']) ?>
												</li>
												<li>
													<?=  Html::a('Zobacz notatke', $show_note_url.'&id='.$training->id,['class' => '']) ?>
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

					<div>
						<?php

						// display pagination
						echo LinkPager::widget([
							'pagination' => $pagination,
						]);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script>


</script>
