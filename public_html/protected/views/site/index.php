<?php
/**
 * @var TbActiveForm $form
 * @var Link $model
 * @var SiteController $this
 */
$this->pageTitle = Yii::t('site', Yii::app()->name);

?>
<div class="row-fluid google-style-container">
	<div class="span6 offset3">
		<div class="row-fluid">
			<?php
			$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id' => 'create_link_form',
				'type' => 'inline',
				'action' => '/add',
				'enableAjaxValidation' => true,
				'enableClientValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
					'validateOnChange' => false,
					'afterValidate' => 'js:function(form, data, hasError){
					$("#short_link_container").hide();
					if(!hasError){
						submitForm();
					}
					return false;
				}'
				),
				'htmlOptions' => array(
					'class' => 'text-center'
				)
			));


			echo $form->textFieldRow($model, 'url', array(
				'class' => 'google-style-long-field',
				'placeholder' => Yii::t('site', 'Enter the link you want to shorten')
			)); ?>

			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'submit_form_button',
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => Yii::t('site', 'Shorten'),
				'htmlOptions' => array(
					'data-ajax' => Yii::t('site', 'Processing')
				)
			)); ?>

			<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6 offset3 text-center hide" id="short_link_container">
			<h5><a href="" target="_blank" id="long_link"></a></h5>
			<i class="fa fa-chevron-down big-arrow text-success"></i>

			<h2 id="short_link"></h2>
		</div>
	</div>
</div>


