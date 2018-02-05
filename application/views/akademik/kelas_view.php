<section class="content-header">
      		<h1>Data Kelas</h1>
    	</section>

    	<section class="content">
      		<div class="row">
        		<div class="col-xs-12">
          			<div class="box">
            			<div class="box-body">
						<div class="table-responsive">
              				<button class="btn btn-success" onClick="tambah_kelas()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
    						<br />
    						<br />
    						<table id="table_kelas" class="table table-striped table-bordered" cellspacing="0" width="100%">
      							<thead>
        							<tr>
          								<th width="53">No</th>
          								<th width="198">Kelas</th>
          								<th width="145" style="width:125px;">Action</th>
       								</tr>
      							</thead>
      							<tbody>
      							<?php
								$no = 1;
      							foreach($kelas as $kelass) {
      							?>
             						<tr>
                						<td><?php echo $no++ ?></td>
                						<td><?php echo $kelass->kelas; ?></td>
                						<td><button class="btn btn-warning" onClick="edit_kelas(<?php echo $kelass->id_kelas; ?>)">Edit</button>&nbsp;<button class="btn btn-danger" onClick="hapus_kelas(<?php echo $kelass->id_kelas; ?>)">Hapus</button></td>
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
	$('#table_kelas').DataTable();
  	});
  	var save_method; //for save method string
  	var table;

function tambah_kelas()
{
	save_method = 'add';
	$('#form')[0].reset(); // reset form on modals
	$('#modal_form').modal('show');
}

function save()
{
    var url;

    if(save_method == 'add'){
		url= '<?php echo site_url('index.php/akademik/kelas/tambah_kelas');?>';
	} else {
		url= '<?php echo site_url('index.php/akademik/kelas/update_kelas');?>';
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

function edit_kelas(id)
{
	save_method = 'update';
	$('#form')[0].reset();

	$.ajax({
		url: "<?php echo site_url('index.php/akademik/kelas/ajax_edit/') ; ?>/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
			$('[name="id_kelas"]').val(data.id_kelas);
      $('[name="kelas"]').val(data.kelas);
          
		  	$('#modal_form').modal('show');
          	$('.modal_title').text('Edit Kelas');
        }, 
        error: function(jqXHR, textStatus, errorThrown) {
          	alert('Error Get Data From Ajax');
        }
	});
}

function hapus_kelas(id_kelas)
{
	if(confirm('Are you ready to die ?')){
		$.ajax({
			url: "<?php echo site_url('index.php/akademik/kelas/hapus_kelas'); ?>/"+id_kelas,
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
        <h3 class="modal-title">Form Kelas</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_kelas"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kelas</label>
              <div class="col-md-9">
                <input name="kelas" placeholder="Kelas" class="form-control" type="text">
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