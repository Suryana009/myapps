
<section class="content-header">
      		<h1>Data Buku</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_buku()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="53">No</th>
          								<th width="279">Judul</th>
          								<th width="276">Pengarang</th>
          								<th width="198">Kategori</th>
										<th width="198">Lokasi</th>
          								<th width="127">ISBN</th>
          								<th width="145" style="width:125px;">Action</th>
       								</tr>
      							</thead>
      							<tbody>
      							<?php
								$no = 1;
      							foreach($buku as $bukus) {
      							?>
             						<tr>
                						<td><?php echo $no++ ?></td>
                						<td><?php echo $bukus->judul; ?></td>
                						<td><?php echo $bukus->pengarang; ?></td>
                						<td><?php echo $bukus->kategori; ?></td>
										<td><?php echo $bukus->lokasi; ?></td>
                						<td><?php echo $bukus->isbn; ?></td>
                						<td><button class="btn btn-warning" onClick="edit_buku(<?php echo $bukus->id_buku; ?>)">Edit</button>&nbsp;<button class="btn btn-danger" onClick="hapus_buku(<?php echo $bukus->id_buku; ?>)">Hapus</button></td>
              						</tr>
          						<?php } ?>
      							</tbody>
    						</table>
            			</div>
						</div>
					</div>
				</div>
			</div>
		</section>
  	
<script src="<?php echo base_url('assets/jQuery/jquery-2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('#table_id').DataTable();

  	});

  $(document).ready(function () {
  $('.tanggal').datepicker({
    format: "yyyy-mm-dd",
    autoclose:true
  });
});

  	var save_method; //for save method string
  	var table;

function tambah_buku()
{
	save_method = 'add';
	$('#form')[0].reset(); // reset form on modals
	$('#modal_form').modal('show');
}

function save()
{
    var url;

    if(save_method == 'add'){
		url= '<?php echo site_url('index.php/perpustakaan/buku/tambah_buku');?>';
	} else {
		url= '<?php echo site_url('index.php/perpustakaan/buku/update_buku');?>';
	}

	$.ajax({
		url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data){
			$('#modal_form').modal('hide');
          	location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown){
			alert('Error adding/ Update data');
        }
	});
}

function edit_buku(id)
{
	save_method = 'update';
	$('#form')[0].reset();

	$.ajax({
		url: "<?php echo site_url('index.php/perpustakaan/buku/ajax_edit/') ; ?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
			$('[name="id_buku"]').val(data.id_buku);
          	$('[name="judul"]').val(data.judul);
          	$('[name="pengarang"]').val(data.pengarang);
          	$('[name="id_kategori"]').val(data.id_kategori);
			$('[name="id_lokasi"]').val(data.id_lokasi);
          	$('[name="isbn"]').val(data.isbn);
          
		  	$('#modal_form').modal('show');
          	$('.modal_title').text('Edit Buku');
        }, 
        error: function(jqXHR, textStatus, errorThrown) {
          	alert('Error Get Data From Ajax');
        }
	});
}

function hapus_buku(id_buku)
{
	if(confirm('Are you ready to die ?')){
		$.ajax({
			url: "<?php echo site_url('index.php/perpustakaan/buku/hapus_buku'); ?>/"+id_buku,
          	type: "POST",
          	dataType: "JSON",
          	success: function(data) {
            	location.reload();
          	},
          	error: function(jqXHR, textStatus, errorThrown) {
            	alert('Error Deleting Data');
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
        <h3 class="modal-title">Form Buku</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_buku"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Judul</label>
              <div class="col-md-9">
                <input name="judul" placeholder="Judul" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Pengarang</label>
              <div class="col-md-9">
                <input name="pengarang" placeholder="Pengarang" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kategori</label>
              <div class="col-md-9">
                <select name="id_kategori" class="form-control">
				<option value="">Pilih</option>
				<?php foreach($kategori as $row){?>
           		<option value="<?php echo $row->id_kategori ?>"><?php echo $row->kategori ?></option>
           		<?php } ?>
				</select>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Lokasi</label>
              <div class="col-md-9">
                <select name="id_lokasi" class="form-control">
				<option value="">Pilih</option>
				<?php foreach($lokasi as $row){?>
           		<option value="<?php echo $row->id_lokasi ?>"><?php echo $row->lokasi ?></option>
           		<?php } ?>
				</select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">ISBN</label>
              <div class="col-md-9">
                <input name="isbn" placeholder="ISBN" class="form-control" type="text">
 
              </div>
            </div>
			<!-- <div class="form-group">
              <label class="control-label col-md-3">Tanggal Input</label>
              <div class="col-md-9">
                <input name="tgl_input" class="form-control tanggal" type="text">
              </div>
            </div> -->
 
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>