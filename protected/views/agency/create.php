<?php

$this->pageTitle=Yii::app()->name . ' - Create agency';
$this->breadcrumbs=array(
	'Agencies',
);
?>

<h1>Create agency</h1>

<?php if(Yii::app()->user->hasFlash('aCreated')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('aCreated'); ?>
</div>

<?php else: ?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($agency); ?>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_name'); ?>
		<?php echo $form->textField($agency,'a_name'); ?>
		<?php echo $form->error($agency,'a_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_description'); ?>
		<?php echo $form->textArea($agency,'a_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($agency,'a_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_skype'); ?>
		<?php echo $form->textField($agency,'a_skype'); ?>
		<?php echo $form->error($agency,'a_skype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_cell_phone'); ?>
		<?php echo $form->textField($agency,'a_cell_phone'); ?>
		<?php echo $form->error($agency,'a_cell_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_email'); ?>
		<?php echo $form->textField($agency,'a_email'); ?>
		<?php echo $form->error($agency,'a_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_country_code'); ?>
		<?php echo $form->dropDownList($agency,'a_country_code', Yii::app()->params['countries'], array('empty' => 'Select your country')); ?>
		<?php echo $form->error($agency,'a_country_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($agency,'a_city'); ?>
		<?php echo $form->dropDownList($agency,'a_city', Yii::app()->params['cities'], array('empty' => 'Select your city')); ?>
		<?php echo $form->error($agency,'a_city'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>