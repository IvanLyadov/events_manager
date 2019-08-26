<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel-heading">
	Zadania na dzień <?php echo date("d-m-Y", $selectedDayTime) ?>

	<?php
		$day_in_pl = \app\helpers\TimeHelper::getPolishDayName( date("l", $selectedDayTime) );
		echo " (" . $day_in_pl . ")";
	?>
</div>


<div id="user-task-list" class="user-task-list">
	<?php
		$lp = 1;
		$task_count = count($user_tasks);
	?>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="46%">
					Zadanie
				</th>
				<th width="45%">
					Opis
				</th>
				<th width="9%">
					Akcje
				</th>

			</tr>
		</thead>

		<tbody>
			<?php foreach ($user_tasks as $user_task): ?>

				<tr class="user-task">

					<td style="text-align:left;">
						<?php
							echo $user_task->title;
						?>
					</td>

					<td style="text-align:left;">
						<?= $user_task->description; ?>
					</td>

					<td>
						<div class="dropdown ">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								<span class="caret"></span>
							</button>

							<ul class="dropdown-menu task-dropdown" aria-labelledby="user-tasks">
								<li>
									<a href="<?php echo Url::to(['user-tasks/edit', 'task_id' => $user_task->id]) ?>" class="glyphicon glyphicon-pencil green task-icons" title="Edytuj"></a>
								</li>

								<li>
									<a href="<?php echo Url::to(['user-tasks/delete', 'task_id' => $user_task->id]) ?>" onclick="return confirm('czy na pewno chcesz usunąć zadanie?')" class="glyphicon glyphicon-remove red task-icons" title="Usuń"></a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
