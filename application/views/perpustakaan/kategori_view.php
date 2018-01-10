<section class="content-header">
      		<h1>Data Kategori</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_kategori()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_kategori" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="53">No</th>
          								<th width="198">Kategori</th>
          								<th width="145" style="width:125px;">Action</th>
       								</tr>
      							</thead>
      							<tbody>
      							<?php
								$no = 1;
      							foreach($kategori as $kategoris) {
      							?>
             						<tr>
                						<td><?php echo $no++ ?></td>
                						<td><?php echo $kategoris->kategori; ?></td>
                						<td><button class="btn btn-warning" onClick="edit_kategori(<?php echo $kategoris->id_kategori; ?>)">Edit</button>&nbsp;<button class="btn btn-danger" onClick="hapus_kategori(<?php echo $kategoris->id_kategori; ?>)">Hapus</button></td>
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
  	

<script src="<?php echo base_url('assets/jQuery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js')?>"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('#table_kategori').DataTable();
  	});
  	var save_method; //for save method string
  	var table;

function tambah_kategori()
{
	save_method = 'add';
	$('#form')[0].reset(); // reset form on modals
	$('#modal_form').modal('show');
}

function save()
{
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
	
	var url;

    if(save_method == 'add'){
		url= '<?php echo site_url('index.php/perpustakaan/kategori/tambah_kategori');?>';
	} else {
		url= '<?php echo site_url('index.php/perpustakaan/kategori/update_kategori');?>';
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

function edit_kategori(id)
{
	save_method = 'update';
	$('#form')[0].reset();

	$.ajax({
		url: "<?php echo site_url('index.php/perpustakaan/kategori/ajax_edit/') ; ?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
			$('[name="id_kategori"]').val(data.id_kategori);
      $('[name="kategori"]').val(data.kategori);
      $('[name="berita"]').val(data.berita);
      $('[name="buku"]').val(data.buku);
      $('[name="ebook"]').val(data.ebook);
          
		  	$('#modal_form').modal('show');
          	$('.modal_title').text('Edit Kategori');
        }, 
        error: function(jqXHR, textStatus, errorThrown) {
          	alert('Error Get Data From Ajax');
        }
	});
}

function hapus_kategori(id_kategori)
{
	if(confirm('Are you ready to die ?')){
		$.ajax({
			url: "<?php echo site_url('index.php/perpustakaan/kategori/hapus_kategori'); ?>/"+id_kategori,
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
        <h3 class="modal-title">Form Kategori</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_kategori"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kategori</label>
              <div class="col-md-9">
                <input name="kategori" placeholder="Kategori" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Berita</label>
              <div class="col-md-9">
                <select name="berita" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Aktif</option>
                  <option value="0">Non Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Buku</label>
              <div class="col-md-9">
                <select name="buku" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Aktif</option>
                  <option value="0">Non Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Ebook</label>
              <div class="col-md-9">
                <select name="ebook" class="form-control">
                  <option value="">Pilih</option>
                  <option value="1">Aktif</option>
                  <option value="0">Non Aktif</option>
                </select>
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