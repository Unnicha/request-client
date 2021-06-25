<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>

	<!-- Judul Table-->
	<h2 class="mb-3" align="center"> <?= $judul; ?> </h2>
	
	<div class="row"> 
		<!-- Form Ganti Tampilan -->
		<div class="col col-sm">
			<form action="" method="post">
				<div class="row form-inline">
				<div class="col px-0">
					<!-- Ganti Bulan -->
					<select name='bulan' class="form-control" id="bulan">
						<?php 
							$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
							foreach ($masa as $m) : 
								$pilih="";
								if ($m['id_bulan'] == $bulan) 
								{ $pilih="selected"; } 
								?>
						<option value="<?=$m['id_bulan']?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<!-- Ganti Tahun -->
					<select name='tahun' class="form-control" id="tahun">
						<?php 
							$tahun = date('Y');
							$sess_tahun = $this->session->userdata('tahun');
							for($i=$tahun; $i>=2010; $i--) :
								if ($i == $sess_tahun) 
								{ $pilih="selected"; } 
								else 
								{ $pilih=""; }
								?>
							<option value="<?= $i ?>" <?= $pilih; ?>> <?= $i ?> </option>
						<?php endfor ?>
					</select>
					
					<!-- Ganti Klien -->
					<select name='klien' class="form-control" id="klien">
						<option value=""> Semua Klien </option>
							<?php 
							$sess_klien = $this->session->userdata('klien');
							foreach ($klien as $k) :
								if ($k['id_klien'] == $sess_klien) 
								{ $pilih="selected"; } 
								else 
								{ $pilih=""; }
							?>
						<option value="<?= $k['id_klien']; ?>" <?= $pilih; ?>>
							<?= $k['nama_klien'] ?>
						</option>
							<?php endforeach ?>
					</select> 
					</div>
				</div>
			</form>
		</div>

		<!-- Tombol Tambah Permintaan -->
		<div class="col col-sm-3">
			<a href="<?= base_url(); ?>admin/permintaan/permintaan_data_perpajakan/tambah" class="btn btn-success float-right">
				<i class="bi-plus"></i>
				Tambah
			</a>
		</div>
	</div>
	
	<div class="mt-2 mb-4">
		<table id="myTable" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama Klien</th>
					<th scope="col">Permintaan ke</th>
					<th scope="col">Tanggal Permintaan</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>

<!-- Modal untuk Detail Permintaan -->
<div class="modal fade" id="detailPermintaan" tabindex="-1" aria-labelledby="detailPermintaanLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" style="width:500px">
		<div class="modal-content" id="showDetailPermintaan">
			<!-- Tampilkan Data Klien-->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() { 
		var notif = $('.notification').data('val');
		if(notif == 'yes') {
			$('#modalNotif').modal('show');
				setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			//'pageLength': 9,
			'ajax'		: {
				'url'	: '<?=base_url()?>admin/permintaan/permintaan_data_perpajakan/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
		});
		
		$("#klien").change(function() { 
			table.draw();
		})
		$('#bulan').change(function() {
			table.draw();
		})
		$('#tahun').change(function() {
			table.draw();
		})
	});
	
	$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
		$(this).tooltip();
	});
	
	// Detail Permintaan
	$('#myTable tbody').on('click', 'a.btn-detail_permintaan', function() {
		var permintaan = $(this).data('nilai');
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>admin/permintaan/permintaan_data_perpajakan/detail',
			data: 'permintaan='+ permintaan,
			success: function(data) {
				$("#detailPermintaan").modal('show');
				$("#showDetailPermintaan").html(data);
			}
		})
	});
</script>