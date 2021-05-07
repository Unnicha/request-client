<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?> 
	
	<?php if($this->session->flashdata('warning')) : ?>
		<div class="warning" data-val="yes"></div>
	<?php endif; ?> 

	<!-- Judul Table-->
	<h2 align="center"><?= $judul ?></h2>
	
	<div class="row float-left mt-1">
		<!-- Tombol Tambah Data -->
		<div class="col">
			<a href="<?= base_url(); ?>admin/otoritas/tambah" class="btn btn-success">
				<i class="bi-plus"></i>
				Tambah
			</a> 
		</div>
	</div>
	
	<div class="mt-3 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm mt-3">
			<!-- Header Table-->
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Admin</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<!-- Body Table-->
			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>


<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
		//sidebar menu show
		$('#menu1').collapse('show');
		
		$(document).ready(function () {
			//pop up message success
			var notif = $('.notification').data('val');
			if(notif == 'yes') {
				$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
			}
			//pop up message failed
			var warning = $('.warning').data('val');
			if(warning == 'yes') {
				$('#modalWarning').modal('show');
				setTimeout(function(){ $('#modalWarning').modal('hide'); },2000);
			}

			//show tooltip
			$(function() {
				$('[data-toggle="tooltip"]').tooltip();
			})

			//view table
			var table = $('#myTable').DataTable({
				'processing': true,
				'serverSide': true,
				'ordering'	: false,
				'lengthChange': false,
				//'pageLength': 9,
				'ajax'		: {
					'url'	: '<?=base_url()?>admin/otoritas/page',
					'type'	: 'post',
				},
			});
		})

</script>