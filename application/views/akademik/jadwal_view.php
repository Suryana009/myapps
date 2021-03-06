<section class="content-header">
      		<h1>Data Jadwal Mengajar</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_jadwal()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_jadwal" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="3">No</th>
										<th width="279">ID Jadwal</th>
          								<th width="279">Nama Guru</th>
          								<th width="276">Mata Pelajaran</th>
										<th width="198">Kelas</th>
										<th width="130">Hari</th>
          								<th width="130">Jam</th>
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
    table = $('#table_jadwal').DataTable({ 
    "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
    "ajax": {
            "url": "<?php echo site_url('akademik/jadwal/show_jadwal_DT')?>",
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



function tambah_jadwal()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Tambah Berita'); // Set Title to Bootstrap modal title
}

function update_jadwal(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $.ajax({
        url : "<?php echo site_url('index.php/akademik/jadwal/ajax_edit')?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_jadwal"]').val(data.id_jadwal);
            $('[name="id_guru"]').val(data.id_guru);
            $('[name="id_kelas"]').val(data.id_kelas);
            $('[name="hari"]').val(data.hari);
            $('[name="jam"]').val(data.jam);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Jadwal Mengajar'); // Set title to Bootstrap modal title
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
        url = "<?php echo site_url('index.php/akademik/jadwal/tambah_jadwal')?>";
    } else {
        url = "<?php echo site_url('index.php/akademik/jadwal/update_jadwal')?>";
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

function hapus_jadwal(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/akademik/jadwal/hapus_jadwal')?>/"+id,
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
        		<h3 class="modal-title">Form Jadwal Mengajar</h3>
      		</div>
      		<div class="modal-body form">
        		<form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
          			<input type="hidden" value="" name="id_jadwal"/>
          				<div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Guru</label>
                        <div class="col-md-9">
                          <select name="id_guru" class="form-control">
                  <option value="">Pilih</option>
                  <?php foreach($guru as $row){?>
                        <option value="<?php echo $row->id_guru ?>"><?php echo $row->nama_lengkap ?></option>
                        <?php } ?>
                  </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Kelas</label>
                        <div class="col-md-9">
                          <select name="id_kelas" class="form-control">
                  <option value="">Pilih</option>
                  <?php foreach($kelas as $row){?>
                        <option value="<?php echo $row->id_kelas ?>"><?php echo $row->kelas ?></option>
                        <?php } ?>
                  </select>
                        </div>
                    </div>
            				<div class="form-group">
              					<label class="control-label col-md-3">Hari Mengajar</label>
              					<div class="col-md-9">
                					<select name="hari" class="form-control">
                          <option value="">Pilih</option>  
                          <option value="Senin">Senin</option>  
                          <option value="Selasa">Selasa</option>  
                          <option value="Rabu">Rabu</option>  
                          <option value="Kamis">Kamis</option>  
                          <option value="Jumat">Jumat</option>  
                          <option value="Sabtu">Sabtu</option>    
                          </select>
									<span class="help-block"></span>
              					</div>
            				</div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Jam Mengajar</label>
                        <div class="col-md-9">
                          <input name="jam" placeholder="Jam Mengajar" class="form-control" type="text">
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