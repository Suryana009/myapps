<section class="content-header">
      		<h1>Data Berita</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_berita()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_berita" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="3">No</th>
										<th width="279">ID Berita</th>
          								<th width="279">Judul Berita</th>
          								<th width="276">Deskripsi</th>
										<th width="198">Tanggal Posting</th>
          								<th width="130">File</th>
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
		
<script src="<?php echo base_url('assets/jQuery/jquery-2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;
$(document).ready(function() {
  //datatables
    table = $('#table_berita').DataTable({ 
    "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
    "ajax": {
            "url": "<?php echo site_url('akademik/berita/show_berita_DT')?>",
            "type": "POST"
        },
    "columnDefs": [
        { 
            "targets": [ 0,6 ], 
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



function tambah_berita()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Tambah Berita'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal

    $('#label-photo').text('Upload File'); // label photo upload
}

function update_berita(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('index.php/akademik/berita/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_berita"]').val(data.id_berita);
            $('[name="judul_berita"]').val(data.judul_berita);
            $('[name="deskripsi"]').val(data.deskripsi);
            $('[name="tgl_posting"]').datepicker('update',data.tgl_posting);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Berita'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.file)
            {
                $('#label-photo').text('Change File'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'berita/'+data.file+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.file+'"/> Remove photo when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload File'); // label photo upload
                $('#photo-preview div').text('(No File)');
            }


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
    $('#btnSave').attr('Disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('index.php/akademik/berita/tambah_berita')?>";
    } else {
        url = "<?php echo site_url('index.php/akademik/berita/update_berita')?>";
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
            $('#btnSave').attr('Disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('Disabled',false); //set button enable 

        }
    });
}

function hapus_berita(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/akademik/berita/hapus_berita')?>/"+id,
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
        <h3 class="modal-title">Form Berita</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_berita"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Judul</label>
              <div class="col-md-9">
                <input name="judul_berita" placeholder="Judul Berita" class="form-control" type="text">
				<span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Deskripsi</label>
              <div class="col-md-9">
                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
				<span class="help-block"></span>
              </div>
            </div>
			<div class="form-group" id="photo-preview">
              <label class="control-label col-md-3">Photo</label>
                 <div class="col-md-9">
                                
                 <span class="help-block"></span>
              	 </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">File</label>
              <div class="col-md-9">
                <input type="file" name="file" />
				<span class="help-block"></span>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Tanggal Posting</label>
              <div class="col-md-9">
                <input name="tgl_posting" id="datepicker" placeholder="" class="form-control datepicker" type="text">
				<span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
 
  </body>
</html>