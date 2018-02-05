<section class="content-header">
		<h1>Data Kalender</h1>
</section>

<section class="content">
		<div class="row">
		<div class="col-xs-12">
  			<div class="box">
				<div class="box-body">
        			<div class="col-md-12 column">
                		<div id="calendar"></div>
        			</div>
				</div>
    		</div>
		</div>
	</div>
</section>
<script src="<?php echo base_url('assets/moment/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/jQueryUI/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/booststrap-validator/bootstrapValidator.min.js');?>"></script>
<script src="<?php echo base_url('assets/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo base_url('assets/bootstrap-colorpicker/bootstrap-colorpicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/jQueryUI/main.js');?>"></script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                <input type="hidden" id="start">
                <input type="hidden" id="end">
				<div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="title">Title</label>
                        <div class="col-md-9">
                            <input id="title" name="title" type="text" class="form-control" />
                        </div>
                    </div>                            
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="color">Color</label>
                        <div class="col-md-9">
                            <input id="color" name="color" type="text" class="form-control" readonly="readonly" />
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div>
					</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>