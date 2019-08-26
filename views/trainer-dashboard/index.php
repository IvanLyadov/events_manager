<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
 ?>


<?=$this->render('../_global_container.php')?>


<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2>
						Pulpit
					</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Najbliższe zajęcia</h3>
					</div>
					<!-- <div class="panel-body">
						Panel content
					</div> -->
					<table class="table table-striped table-bordered dashbord-trainings">
						<thead>
							<tr>
								<th class="investment-name" width="9%">
									Data/Czas
								</th>
								<th width="15%">
									Opis
								</th>
								<th width="12%">
									Nazwa treningu
								</th>
								<th width="12%">
									Imię/Nazwisko trenującego
								</th>
								<th width="12%">
									Tel. kontaktowy
								</th>
								<th width="13%">
									Nazwa dyscypliny
								</th>
								<th width="2%">
									Notatki
								</th>
								<th width="5%">
									Opcje
								</th>
							</tr>
						</thead>
						<?php foreach ($trainings_records as $training): ?>
							<?php
								$next_day = mktime(0,0,0,date("n", time()),date("j", time())+ 1 ,date("Y", time() ));
								$prev_day = mktime(0,0,0,date("n", time()),date("j",time())- 1 ,date("Y", time() ));
								$current_day ="";
								if ($training->start_ts < $next_day) {
									$current_day = "dashbord-current_day";
								}
							 ?>
							<tr>
								<td class="<?= $current_day ?>">
									<?= date('d-m-Y H:i', $training->start_ts) ?>
								</td>
								<td class="<?= $current_day ?>">
									<?= $training->description ?>
								</td>
								<td class="<?= $current_day ?>">
									<?= $training->title ?>
								</td>
								<td class="<?= $current_day ?>">
									<?php
										if (isset($training->user->first_name) && isset($training->user->last_name) ) {
											echo $training->user->first_name . ' ' . $training->user->last_name;
										}
									?>
								</td>
								<td class="<?= $current_day ?>">
									<?php if (isset($training->user->phone)): ?>
										<?= $training->user->phone?>
									<?php endif ?>
								</td>
								<td class="<?= $current_day ?>">
									<?php if (isset($training->activitie->name)) {
										echo $training->activitie->name;
									}  ?>
								</td>
								<td class="<?= $current_day ?>">
										<?php if (!empty($training->trainingsNote)): ?>
												<?php $notes_content = ''; ?>
											<?php foreach ($training->trainingsNote as $trainings_note): ?>


													<?php
														$notes_content .= "<span>" . $trainings_note->title . '<span style="display:block;"></span>' . $trainings_note->description . '<span style="display:block;">____________________________</span> </span>';
													 ?>
											<?php endforeach ?>
											<a href="javascript:void(0);" class="notes-show glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="bottom" title="Zobacz notatki" >
											</a>
											<span class="notest-pop-up">
												<span class="notes-popup-message">
													<span class="close-notes">X</span>
														<?= $notes_content ?>
												</span>
											</span>
										<?php endif ?>
								</td>
								<td>
									<div class="dropdown ">
										<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Opcje
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<!-- <li><a href="#">Wyślij sms</a></li> -->
											<?php if (isset($training->user['id'])): ?>
												<li><?= Html::a('', Url::to(['index.php/trainings?id_user='. $training->user['id'] ]) , ['class'=>'glyphicon glyphicon-sunglasses', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Wyświetl treningi']) ?></li>
												<li><?= Html::a('', Url::to(['index.php/trainings_notes/new?id_user='. $training->user['id'] .'&id='. $training->id ]) , ['class'=>'glyphicon glyphicon-pencil', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Dodaj notatkę']) ?></li>
												<li><?= Html::a('', Url::to(['trainings_notes/show_note?id_user='. $training->user['id'] .'&id='. $training->id ]) , ['class'=>'glyphicon glyphicon-comment', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Zobacz wszystkie notatki']) ?></li>
												<li><?= Html::a('', Url::to(['index.php/clients/send_email?user_id='. $training->user['id'] ]) , ['class'=>'glyphicon glyphicon-send', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Wyślij e-mail']) ?></li>
											<?php endif ?>
											<!-- <li><a href="#">Wyślij e-mail i sms</a></li> -->
											<!-- <li><a href="#" >Zablokuj osobę</a></li> -->
										</ul>
									</div>
									<div class="clearfix"></div>
								</td>
							</tr>
						<?php endforeach ?>

					</table>
				</div>


			</div>
		</div>

	</div>

</div>
<script>

</script>
<?php
$script = <<< JS
	jQuery(document).ready(function($) {
		$('.notes-show').click(function(event){
			$(this).siblings('.notest-pop-up').fadeIn('fast');
		});
		$(document).on('click', '.close-notes', function(event) {
			$(this).parents('.notest-pop-up').fadeOut('fast');
		});
	});
JS;
$this->registerJs($script);
?>
