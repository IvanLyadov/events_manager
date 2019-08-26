<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?= $this->render('../_global_container.php') ?>

<div class="gl-container">
    <div class="content-box">
        <div class="row">
            <div class="col-xs-12 col-md-9 col-lg-9">
                <div class="title-section">
                    <h2>
                          Lista zadań
                    </h2>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                        <div type="button" class="btn btn-default">
							<?= Html::a('Wstecz', $back_url, ['class' => '']) ?>
                        </div>
                        <form class="form-search-date" method="get">
	                        <label class="oldtask-table">Pokaż od</label>
                            <span class="user-task__item">
                              <input type="text" name="date" id="text-calendar" class="calendar form-control oldtask-table"
                                     placeholder="<?= isset($searchByDate) ? (!empty($searchByDate) ? $searchByDate : date("d-m-Y")) : date("d-m-Y")?>"
                                     value=""
                              />
                            </span>
                            <span class="user-task__item">
                              <input type="text" name="search"
                                     class="oldtask-table form-control"
                                     placeholder="<?= isset($searchByText) ? (!empty($searchByText) ? $searchByText : 'szukany tekst') : 'szukany tekst' ?>"/>
                            </span>
							<? if(isset($orderByDate)&&!empty($orderByDate)):?>
								<input type="hidden" name="dateOrder" value="<?=$orderByDate?>">
	                        <?endif;?>
                            <input type="submit" class="btn btn-default" value="szukaj">
                        </form>
                    </div>
                    <table class="table table-striped table-bordered oldtask-table">
                        <thead>
                        <tr>
                            <th width="20%">
                                <a href="<?= ($orderByDate ? ($orderByDate == 'ASC' ? '?dateOrder=DESC' : '?dateOrder=ASC') : '?dateOrder=ASC')?>">Data</a>
                            </th>
                            <th width="35%">Zadanie</th>
                            <th width="35%">Opis</th>
                            <th width="10%">Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php
						$dayNames = array(
							'(Nd.)',
							'(Pn.)',
							'(Wt.)',
							'(Śr.)',
							'(Cz.)',
							'(Pt.)',
							'(Sb.)',
						);
						?>
						<?php foreach ($userTasks as $task): ?>
                            <tr>
                                <td>
                                    <?php if ($task->day_start_ts == '2000000000'): ?>
                                        <?= 'bezterminowe' ?>
                                    <?php else: ?>
                                        <?= date("d-m-Y", $task->day_start_ts) ?>
                                        <?= $dayNames[date("w", $task->day_start_ts)] ?>
                                    <?php endif ?>

                                </td>
                                <td class="task-header" data-toggle="tooltip" data-html="true" data-container="body"
                                    data-placement="top" title="<span><?php echo $task->description; ?> </span>">
									<?php echo substr($task->description, 0, 50) . " ..."; ?>

                                </td>
                                <td class="task-header">
									<?= $task->title; ?>
                                </td>
                                <td>
                                    <div class="dropdown ">
                                        <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu task-dropdown" aria-labelledby="user-tasks">
                                            <li>
                                                <a href="<?php echo Url::to(['user-tasks/edit', 'task_id' => $task->id, 'module_url' => Yii::$app->request->url]) ?>"
                                                   class="glyphicon glyphicon-pencil green task-icons"
                                                   title="Edytuj"></a>
                                            </li>

                                            <li>
                                                <a href="<?php echo Url::to(['user-tasks/delete', 'task_id' => $task->id, 'module_url' => Yii::$app->request->url]) ?>"
                                                   onclick="return confirm('czy na pewno chcesz usunąć zadanie?')"
                                                   class="glyphicon glyphicon-remove red task-icons" title="Usuń"></a>
                                            </li>
                                        </ul>
                                    </div>
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


<?php
$script = <<< JS
	jQuery(document).ready(function($) {
		$('.comment-icon').on('click', function(e){
			$(this).children('.comment_template').fadeIn('fast');
		});

		$('.comment_template').on('click', function(e){
			e.stopPropagation();
			$(this).fadeOut('fast');
		})
	});


    $(function() {
        $('input.calendar').pignoseCalendar({
            format: 'DD-MM-YYYY',
            lang: 'pl',
        });
    });


JS;
$this->registerJs($script);
?>
