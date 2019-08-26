<?php
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div>
	<h2>Witaj, <?php echo $user->fullName ?></h2>

	<p>
		Trener <?php echo $trainer->fullName ?> utworzył dla Ciebie konto w naszym systemie.

		Zaloguj się używająć poniżych danych:

		<ul>
			<li>
				Login: <b><?php echo $user->email ?></b>
			</li>

			<li>
				Hasło: <b><?php echo $password ?></b>
			</li>
		</ul>
	</p>

	<a href="<?php echo Url::to(['/login']) ?>">Link do logowania w systemie TDS</a>
</div>