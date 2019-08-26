<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use app\helpers\LightboxHelper;
	use yii\widgets\LinkPager;
 ?>
<?=$this->render('../_global_container.php')?>

<div class="gl-container">
	<div class="content-box">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="title-section">
					<h2 style="display:inline-block;">
						<?= $full_name ?>
					</h2>
					<?php if ($user_status == "coach" || $user_status == "manager"): ?>
					<ul class="nav navbar-nav navbar-right">
						<li class="pd-elem">
						</li>
					</ul>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="row" style="position: relative;">
			<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
				<div class="profileimage">
					<span class="profilimage-item" style="background-image: url('<?= Url::to(['/uploads/user_files/'.$user->avatar_image], 'http') ?>');"></span>
				</div>
			</div>

			<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
				<table class="table borderless text-left profile-table">
					<thead>
						<tr>
							<th width="12%"></th>
							<th width="88%"></th>
						</tr>
					</thead>
					<tr>
						<td>TELEFON:</td>
						<td><?= $user->phone ?></td>
					</tr>
					<tr>
						<td>IMIĘ:</td>
						<td><?= $user->first_name ?></td>
					</tr>
					<tr>
						<td>NAZWISKO:</td>
						<td><?= $user->last_name ?></td>
					</tr>
					<tr>
						<td>EMAIL:</td>
						<td><?= $user->email ?></td>
					</tr>
				</table>
			</div>
				<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
					<?= Html::a('Edytuj profil', $profile_edit_url, ['class' => 'btn btn-default aps-button']) ?>
					<?= Html::a('Edytuj hasło', $password_edit, ['class' => 'btn btn-default aps-button_v2']) ?>
				</div>
		</div>
	</div>
</div>
