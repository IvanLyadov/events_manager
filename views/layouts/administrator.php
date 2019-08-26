<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>

	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800" rel="stylesheet">
</head>
<body>
	<div class="global-container">
<?php $this->beginBody() ?>

<div id="wrapper" class="">

		<div id="sidebar-wrapper">
		<ul id="sidebar_menu" class="sidebar-nav">
				 <li class="sidebar-brand"><a id="menu-toggle" href="#"><?= Yii::$app->name ?><span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
		</ul>
			<ul class="sidebar-nav" id="sidebar">
				<li>
					<?= Html::a('Dashbord <span class="sub_icon glyphicon glyphicon-list-alt"></span>', Url::to(['/trainer/dashboard'])) ?>
				</li>
				<li>
					<?= Html::a('Kalendarz <span class="sub_icon glyphicon glyphicon-calendar"></span>', Url::to(['/trainer/calendar'])) ?>
				</li>
				<li>
					<?= Html::a('Zadania <span class="sub_icon glyphicon glyphicon-th-list"></span>', Url::to(['/trainings/tasks'])) ?>
				</li>
				<li>
					<?= Html::a('Klienci <span class="sub_icon glyphicon glyphicon-user"></span>', Url::to(['/clients'])) ?>
				</li>
				<li>
					<?= Html::a('Galeria <span class="sub_icon glyphicon glyphicon-picture"></span>', Url::to(['/gallery'])) ?>
				</li>
				<li>
					<?= Html::a('Dodaj plik <span class="sub_icon glyphicon glyphicon-download-alt"></span>', Url::to(['/gallery/new'])) ?>
				</li>
				<li>
					<?= Html::a('Profil <span class="sub_icon glyphicon glyphicon-tasks"></span>', Url::to(['/profile'])) ?>
				</li>
			</ul>
		</div>

		<!-- Page content -->
		<div id="page-content-wrapper">
			<div class="page-content inset">
				<div class="main-navbar">
					<?php
					NavBar::begin([
						'brandUrl' => Yii::$app->homeUrl,
						'options' => [
							'class' => 'navbar  navbar-default',
						],
						'innerContainerOptions' => [
							'class' => ''
						]
					]);
					echo Nav::widget([
						'options' => ['class' => 'navbar-nav navbar-left'],
						'items' => [
							'<li class="">' .'<span class="profilimage-icon profilimage-item" style="background-image: url('. Url::to(['/uploads/user_files/'.Yii::$app->user->identity->avatar_image], 'http') . ');"></span>'. '</li>',
							['label' => Yii::$app->user->identity->first_name. ' '.Yii::$app->user->identity->last_name, 'url' => ['/profile'], 'linkOptions'=>['class'=>'', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Profil']],
							Yii::$app->user->isGuest ? (
								['label' => 'Login', 'url' => ['index.php/login']]
							) : (
								'<li class="navbar-right">'
								. Html::beginForm(['index.php/auth/logout'], 'post')
								. Html::submitButton(
									'',
									['class' => 'btn btn-link logout glyphicon glyphicon-log-out', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Wyloguj się']
								)
								. Html::endForm()
								. '</li>'
							)
						],
					]);
					NavBar::end();
					?>
				</div>
			</div>

		<?= $content ?>
<?=$this->render('../_information_form.php')?>

<?php $this->endBody() ?>
		</div>
	</div>
	</div>
</body>
</html>
<?php $this->endPage() ?>
