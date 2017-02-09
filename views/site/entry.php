<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin();?>

<?= $form->field($model, 'name')->label('名称')?>
<?= $form->field($model, 'email')->label('邮箱地址')?>

<div class="form-group">
	<?= Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
</div>

<?php ActiveForm::end();?>