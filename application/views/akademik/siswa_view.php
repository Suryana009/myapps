<section class="content-header">
      		<h1>Data Siswa</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_siswa()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_siswa" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="1">No</th>
										      <th width="50">ID Siswa</th>
                          <th width="100">NIP</th>
          								<th width="200">Nama Lengkap</th>
										      <th width="198">Alamat</th>
                          <th width="10">Kelas</th>
          								<th width="130">Email</th>
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
    table = $('#table_siswa').DataTable({ 
    "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
    	"ajax": {
            "url": "<?php echo site_url('akademik/siswa/show_siswa_DT')?>",
            "type": "POST"
        },
    "columnDefs": [
        { 
            "targets": [ 0,7 ], 
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
    $('#datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd", 
    });
	
	$('#hobby').select2();

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



function tambah_siswa()
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

function update_siswa(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('index.php/akademik/siswa/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_siswa"]').val(data.id_siswa);
            $('[name="nip"]').val(data.nip);
            $('[name="nama_lengkap"]').val(data.nama_lengkap);
			$('[name="alamat"]').val(data.alamat);
            $('[name="tempat_lahir"]').val(data.tempat_lahir);
            $('[name="tanggal_lahir"]').datepicker('update',data.tanggal_lahir);
			$('[name="agama"]').val(data.agama);
			$('[name="hobby"]').val(data.hobby);
			$('[name="telp"]').val(data.telp);
			$('[name="email"]').val(data.email);
			$('[name="password"]').val(data.password);
			$('[name="id_kelas"]').val(data.id_kelas);
			$('[name="status_siswa"]').val(data.status_siswa);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Siswa'); // Set title to Bootstrap modal title

            $('#photo-preview').show(); // show photo preview modal

            if(data.foto_siswa)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'foto_siswa/'+data.foto_siswa+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.foto_siswa+'"/> Remove photo when saving'); // remove photo

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
        url = "<?php echo site_url('index.php/akademik/siswa/tambah_siswa')?>";
    } else {
        url = "<?php echo site_url('index.php/akademik/siswa/update_siswa')?>";
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

function hapus_siswa(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/akademik/siswa/hapus_siswa')?>/"+id,
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
        <h3 class="modal-title">Form Siswa</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_siswa"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">NIP</label>
              <div class="col-md-9">
                <input name="nip" placeholder="Nomor Induk Pelajar" class="form-control" type="text">
				<span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Nama Lengkap</label>
              <div class="col-md-9">
                <input name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" type="text">
        <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Alamat</label>
              <div class="col-md-9">
                <textarea name="alamat" class="form-control" placeholder="Alamat Siswa"></textarea>
				<span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Tempat Lahir</label>
              <div class="col-md-9">
                <input name="tempat_lahir" placeholder="Nama Lengkap" class="form-control" type="text">
        <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Tanggal Lahir</label>
              <div class="col-md-9">
                <input name="tanggal_lahir" id="datepicker" placeholder="" class="form-control" type="text">
        <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Agama</label>
              <div class="col-md-9">
                <select name="agama" class="form-control">
                  <option value="">Pilih</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen">Kristen</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Budha">Budha</option>
                </select>
        <span class="help-block"></span>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Hobby</label>
              <div class="col-md-9">
                <!-- <select multiple="multiple" name="hobby[]" id="hobby" class="form-control"> -->
				<select name="hobby" class="form-control">
                  <option value="">Pilih</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen">Kristen</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Budha">Budha</option>
                </select>
        <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">No Telepon</label>
              <div class="col-md-9">
                <input name="telp" placeholder="Nomor Telepon Siswa" class="form-control" type="text">
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
              <label class="control-label col-md-3">Foto Siswa</label>
              <div class="col-md-9">
                <input type="file" name="foto_siswa" />
				<span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
                <input name="email" placeholder="Email" class="form-control" type="text">
        <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Password</label>
              <div class="col-md-9">
                <input name="password" placeholder="Password" class="form-control" type="password">
        <span class="help-block"></span>
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
              <label class="control-label col-md-3">Status Siswa</label>
              <div class="col-md-9">
                <select name="status_siswa" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
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
 
  </body>
</html>