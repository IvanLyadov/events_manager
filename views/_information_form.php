<style>
	.popUp-wrapper{
		position: absolute;
		left: 0;
		right: 0;
		margin-left: auto;
		margin-right: auto;
		background: rgba(0, 0, 0, 0.4);
		top: 0;
		bottom: 0;
		z-index: 9999999;
		display: none;
	}
	.popUp-holder{
		position: absolute;
		left: 0;
		right: 0;
		margin-left: auto;
		margin-right: auto;
		top: 50%;
		transform: translateY(-50%);
		background: #fff;
		padding: 20px 20px;
		max-width: 320px;
		max-width: 570px;
	}
	.popUp-holder input{
		display: block;
		width: 100%;
		border-color: #cecece;
		border-radius: 5px;
	}
	.popUp-buttons{
		display: inline-block !important;
		width: auto !important;
	}
	.nav-pop-up{
		margin-top: 20px;
	}
	.input-pop-up textarea{
		width: 100%;
		border-color: #cecece;
		border-radius: 5px;
		resize: none;
		min-height: 140px;
	}
	.input-pop-up{
		margin-bottom: 10px;
	}
	.popUp_formheader{
		padding: 10px;
		z-index: 10;
		background-color: #2196F3;
		color: #fff;
		margin-right: -20px;
		margin-left: -20px;
		margin-top: -20px;
		margin-bottom: 20px;
		font-weight: 600;
	}
</style>
<div class="popUp-wrapper" id="popUp-wrapper">
	<div class="popUp-holder">
		<div class="popUp_formheader">
			Wyślij powiadomienie do Administratora
		</div>
		<form action="/mail-handler/send-email-to-administrator" method="POST" name="sendEmalToAdmin" id="send-emal-to-administrator">
			<div class="input-pop-up">
				<label for="title-poup">Tytuł</label>
				<input type="text" name="title" id="title-poup">
			</div>
			<div class="input-pop-up">
				<label for="description-poup">Treść</label>
				<textarea type="text" name="description" id="description-poup"></textarea>
			</div>
			<input type="hidden" name="link" value="">
			<div class="nav-pop-up">
				<input class="btn btn-success popUp-buttons" type="submit" name="send" value="Wyślij" onclick="">
				<input class="btn btn-danger popUp-buttons" id="popUp-close" type="button" name="send" value="Anuluj" onclick="">
			</div>
		</form>
	</div>
</div>

<?php
$script = <<< JS
	jQuery(document).ready(function($) {
		$(document).on('click', '.send-email-to-admin', function(){
			$('#popUp-wrapper').fadeToggle('fast');
		});

		$(document).on('click', '#popUp-close', function() {
			$('#popUp-wrapper').fadeToggle('fast');
		})

		$('#send-emal-to-administrator').on('submit', function(e){
			document.sendEmalToAdmin.link.value = window.location.href

		});
	});
JS;
$this->registerJs($script);
?>