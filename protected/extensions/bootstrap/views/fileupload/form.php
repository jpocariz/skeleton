<!-- The file upload form used as target for the file upload widget -->
<?php echo CHtml::beginForm($this->url, 'post', $this->htmlOptions); ?>
<div class="fileupload-buttonbar">
    <div class="span4">
        <!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button"> <i class="icon-plus icon-white"></i> <span>Add files...</span>
			<?php
			if ($this->hasModel()) :
				echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n"; else :
				echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
			endif;
			?>
		</span>
            <div class="fileupload-progress fade" style="display:inline;">
                <i class="icon-spinner loadIcon icon-spin"></i>
            </div>

     
    </div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading "></div>
<!-- The table listing the files available for upload/download -->
<div class="row-fluid span8" style="height:5px;">
    <table class="table table-striped">
        <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
    </table>
</div>
<?php echo CHtml::endForm(); ?>

