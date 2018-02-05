<section class="content-header">
      		<h1>Data Mata Pelajaran</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_mapel()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_mapel" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="3">No</th>
										<th width="279">ID Mata Pelajaran</th>
          								<th width="279">Mata Pelajaran</th>
          								<th width="145" style="width:125px;">Action</th>
       								</tr>
      							</thead>
      							<tbody>
      							
      							</tbody>
    						</table>
            			</div>
						</div>
					</div>
				</div>
			</div>
		</section>
  	

<script src="<?php echo base_url('assets/jQuery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.js')?>"></script>
<script src="<?php echo base_url('assets/datepicker/js/bootstrap-datepicker.min.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;
$(document).ready(function() {
  //datatables
    table = $('#table_mapel').DataTable({ 
    "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
    "ajax": {
            "url": "<?php echo site_url('akademik/mapel/show_mapel_DT')?>",
            "type": "POST"
        },
    "columnDefs": [
        { 
            "targets": [ 0,3 ], 
            "orderable": false, 
        },
		{
			"targets": [ 1 ],
			"visible": false,
			"searchable": false,
		},
    ],
    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd", 
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



function tambah_mapel()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Tambah Berita'); // Set Title to Bootstrap modal title
}

function update_mapel(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $.ajax({
        url : "<?php echo site_url('index.php/akademik/mapel/ajax_edit')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_mapel"]').val(data.id_mapel);
            $('[name="mapel"]').val(data.mapel);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Mata Pelajaran'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('index.php/akademik/mapel/tambah_mapel')?>";
    } else {
        url = "<?php echo site_url('index.php/akademik/mapel/update_mapel')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function hapus_mapel(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/akademik/mapel/hapus_mapel')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

  <!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h3 class="modal-title">Form Mata Pelajaran</h3>
      		</div>
      		<div class="modal-body form">
        		<form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
          			<input type="hidden" value="" name="id_mapel"/>
          				<div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Mata Pelajaran</label>
                        <div class="col-md-9">
                          <input name="mapel" placeholder="Mata Pelajaran" class="form-control" type="text">
                  <span class="help-block"></span>
                        </div>
                    </div>
          				</div>
				</form>
			</div>
          	<div class="modal-footer">
            	<button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          	</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <!-- End Bootstrap modal -->