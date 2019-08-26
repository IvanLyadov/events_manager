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
	<!-- <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> -->
</head>
<body>
	<div class="global-container">
<?php $this->beginBody() ?>

	<div class="main-navbar">
		<?php
		NavBar::begin([
			'brandLabel' => Yii::$app->name,
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
				['label' => '', 'url' => ['index.php/trainer/dashboard'], 'linkOptions'=>['class'=>'glyphicon glyphicon-dashboard', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Dashbord']],
				['label' => '', 'url' => ['index.php/user-portal'], 'linkOptions'=>['class'=>'glyphicon glyphicon-calendar', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Kalendarz']],
				['label' => '', 'url' => ['index.php/user/events'], 'linkOptions'=>['class'=>'glyphicon glyphicon-retweet', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Zajęcia grupowe']],
				['label' => '', 'url' => ['index.php/notifications'], 'linkOptions'=>['class'=>'glyphicon glyphicon-envelope', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Powiadomienia']],
				// ['label' => '', 'url' => ['index.php/help'], 'linkOptions'=>['class'=>'glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Strona pomocy']],
				// ['label' => '', 'url' => ['index.php/settings'], 'linkOptions'=>['class'=>'glyphicon glyphicon-cog', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ustawienia']],
				['label' => '', 'url' => ['index.php/user/trainings'], 'linkOptions'=>['class'=>'glyphicon glyphicon-th-list', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Treningi']],

				Yii::$app->user->isGuest ? (
					['label' => 'Login', 'url' => ['index.php/login']]
				) : (
					'<li class="navbar-right">'
					. Html::beginForm(['index.php/auth/logout'], 'post')
					. Html::a(Yii::$app->user->identity->first_name. ' '.Yii::$app->user->identity->last_name, Url::to(['index.php/profile']),['class' => 'login-link', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Użytkownik'])
					. Html::a('', Url::to(['index.php/settings']),['class' => 'settings-logo glyphicon glyphicon-cog', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ustawienia'])
					. '<a class="settings-logo glyphicon glyphicon-alert send-email-to-admin" data-toggle="tooltip" data-placement="bottom" title="Zgłoś problem do Administratora"></a>'
					. Html::a('', Url::to(['index.php/help']),['class' => 'settings-logo glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Strona pomocy'])
					. Html::submitButton(
						'',
						['class' => 'btn btn-link logout glyphicon glyphicon-log-out', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Log out']
					)

					. Html::endForm()
					. '</li>'
				)
			],
		]);
		NavBar::end();
		?>
	</div>

		<?= $content ?>
		<?=$this->render('../_information_form.php')?>


<?php $this->endBody() ?>
	</div>
</body>
</html>
<?php $this->endPage() ?>
