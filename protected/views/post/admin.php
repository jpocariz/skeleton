<?php

	$this->breadcrumbs=array(
		'Posts'=>array('index'),
		'Manage',
	);
?>
<h3 id="demo">Demo</h3>
	The admin page looks like this
	
<?php  
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array(
				'class'=>''
			)
		));
		$this->widget('TbMenu', array(
			'type'=>'pills',
			'items'=>array(
				array('label'=>'Create / Update', 'icon'=>'icon-plus', 'url'=>'#','linkOptions'=>array('class'=>'toggleForm')),
		                array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
				array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'toggleSearch')),
			),
			'htmlOptions'=>array('style'=>'margin-top:2em;'),
		));
		$this->endWidget();
?>
<!-- search-form -->
	<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>

<!-- form -->
	<div id="admin-Post" class="admin-form hide">
	<?php		$this->renderPartial('_form', array('model'=>$model));	?> 
	</div>
<!-- view file is put here-->
	<div class="view-wrapper hide">
		<button class="btn closeViewContent"> <i class="icon-chevron-up"></i> Close</button>
		<div class="view-content"></div>
	</div>
<div class="span8" style="position:relative;">
	<!-- multi delete -->	
<button class="deleteSelected btn btn-danger hide"><i class="icon-trashbin">Delete selected</button>
<div class="select-result" class=""></div>
<?php 
	$updateAttributeUrl = $this->createUrl('post/updateAttribute');
	$this->widget('TbGridView',array(
		'id'=>'post-grid',
		'afterAjaxUpdate'=>"function(id,data){ makeSelectable(id);}", 
		'filter'=>$model,
		'dataProvider'=>$model->search(),
	    'type'=>'striped bordered condensed',
	    'template'=>'{pager}{items}{pager}{summary}',
		'columns'=>array(
			array(
				'class' => 'editable.EditableColumn',
				'name'=>'title',
				'headerHtmlOptions' => array('style' => ''),
				'editable' => array(
					'url' => $updateAttributeUrl,
					'placement' => 'right',
				)
			),
			 array(
			 	'value'=>'Post::parseText($data->content)',
			 	'type'=>'raw',
				'class' => 'editable.EditableColumn',
				'name' => 'content',
				'filter'=>false,
				'editable' => array(
					'type' => 'textarea',
					'url' => $updateAttributeUrl,
					'placement' => 'right',
				)
			), 
			array(
				'class' => 'editable.EditableColumn',
				'name' => 'status',
				'filter'=>false,
				'headerHtmlOptions' => array('style' => 'width: 100px'),
				'editable' => array(
					'type' => 'select',
					'url' => $updateAttributeUrl,
					'source' => Lookup::items('PostStatus'),//$this->createUrl('site/getStatusList'),
					'options' => array( //custom display
						'display' => 'js: function(value, sourceData) {
							var selected = $.grep(sourceData, function(o){ return value == o.value; }),
							colors = {1: "blue", 2: "green", 3: "red"};
							$(this).text(selected[0].text).css("color", colors[value]);
						}'
					),
				//onsave event handler
					'onSave' => 'js: function(e, params) {
						console && console.log("saved value: "+params.newValue);
					}'
				)
			),
			array(
				'header'=>'Created',
				'name'=>'create_time',
				'type'=>'datetime',
				'filter'=>false,
			),
			array(
				//'header' => Yii::t('t', 'Edit'),
			    'type'=>'raw',
			    'value'=>
				    'Chtml::link(CHtml::tag("i",array("class"=>"icon-eye-open"),""),"#",  	
				    	array("class"=>"btn btn-success view","onclick"=>"renderView($data->id,\"/post/view?id=$data->id\")")).
		   		     Chtml::link(CHtml::tag("i",array("class"=>"icon-pencil"),""),"#",
		   		     	array("class"=>"btn btn-primary view","onclick"=>"renderUpdateForm($data->id,\"Post\")")).
					Chtml::link(CHtml::tag("i",array("class"=>"icon-trash"),""),"#",
				  	 	array("class"=>"btn btn-danger view","onclick"=>"delete_record($data->id,\"Post\")"))',
				'htmlOptions'=>array('style'=>'width:120px;')  
			     ),

			),
	)); ?>
</div>
	<div id="crudSource" class="hide">
	<h3> Generated source code</h3>
	The source code for the full version.<br/>
	<div class="btn-group">
		<button class="btn btn-success bOpen" data-target="controllerCode">controller</button>
		<button class="btn btn-success bOpen" data-target="viewCode">view</button>
		<button class="btn btn-success bOpen" data-target="createCode">create</button>
		<button class="btn btn-success bOpen" data-target="updateCode">update</button>
		<button class="btn btn-success bOpen" data-target="adminCode">admin</button>
		<button class="btn btn-success bOpen" data-target="pviewCode">_view</button>
		<button class="btn btn-success bOpen" data-target="formCode">_form</button>
	</div>
		<div id="controllerCode">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../../controllers/PostController.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>250,'each'=>false)));
			?>
		</div>
		<!-- view -->
		<div id="viewCode">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/view.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>78,'each'=>false)));
			?>
		</div>
		<!-- create -->
		<div id="createCode">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/create.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>35,'each'=>false)));
			?>
		</div>
		<!-- update -->
		<div id="updateCode">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/update.php",null,null,0);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>14,'each'=>false)));
			?>
		</div>
		<!-- admin -->
		<div id="adminCode">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/admin.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>148,'each'=>false)));
			?>
		</div>
		<!-- _view -->
		<div id="pviewCode" style="display:none;">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/_view.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>40,'each'=>false)));
			?>
		</div>
		<!-- _form -->
		<div id="formCode" style="display:none">
			<?php
				$code = file_get_contents(dirname(__FILE__)."/../post-demo/_form.php",null,null,1);
				$this->widget('ext.sprism.sprism',array('content'=>$code,'lang'=>'php','lines'=>array('start'=>1,'end'=>30,'each'=>false)));
			?>
		</div>
</div>

<script>
	
	$(function() {
		var grid = $(".grid-view").attr('id');
		makeSelectable(grid);		
	});
</script>
