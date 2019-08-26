<?php if (Yii::$app->session->hasFlash('user_message')): ?>
  <div class="alert-box alert alert-info alert-dismissable registration-alert">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i></h4>
  <?= Yii::$app->session->getFlash('user_message') ?>
  </div>
    <script>
    setTimeout(toggleMessage, 3000);
    function toggleMessage(){
      $('.alert-box').slideToggle('fast');
    }
  </script>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('user_message-error')): ?>
  <div class="alert-box alert alert-danger alert-dismissable registration-alert">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i></h4>
  <?= Yii::$app->session->getFlash('user_message-error') ?>
  </div>

  <script>
    setTimeout(toggleMessage, 3000);
    function toggleMessage(){
      $('.alert-box').slideToggle('fast');
    }
  </script>
<?php endif; ?>