<div class="container-fluid p-0">
	<div class="row mb-2">
		<div class="col form-inline">
			<select name="bulan" class="form-control mr-1" id="bulan_proses">
				<?php 
					$bulan = date('m');
					$sess_bulan = $this->session->userdata('bulan');
					if($sess_bulan) {$bulan = $sess_bulan;}
					foreach ($masa as $m) : 
						if ($m['id_bulan'] == $bulan || $m['nama_bulan'] == $bulan) 
							{ $pilih="selected"; } 
						else 
							{ $pilih=""; }
				?>
				<option value="<?= $m['nama_bulan']; ?>" <?=$pilih?>> <?= $m['nama_bulan'] ?> </option>
				<?php endforeach ?>
			</select>
			
			<select name="tahun" class="form-control mr-1" id="tahun_proses">
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

			<select name="klien" class="form-control mr-1" id="klien_proses">
				<option value="">--Tidak Ada Klien--</option>
			</select> 
		</div>
	</div>
	
	<div id="mb-4">
		<table id="myTable_proses" width=100% class="table table-sm table-bordered table-striped table-responsive-sm">
			<thead class="text-center">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Klien</th>
					<th scope="col">Akuntan</th>
					<th scope="col">Tugas</th>
					<th scope="col">Mulai</th>
					<th scope="col">Durasi</th>
					<th scope="col">Standard</th>
					<th scope="col">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		function gantiKlien() {
			$.ajax({
				type	: 'POST',
				data	: {
					'bulan'	: $('#bulan_proses').val(), 
					'tahun'	: $('#tahun_proses').val(), 
					},
				url		: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/gantiKlien',
				success	: function(data) {
					$("#klien_proses").html(data);
				}
			})
		}
		gantiKlien();

		var table = $('#myTable_proses').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'pageLength'	: 8,
			'ajax'			: {
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien_proses').val(); 
					e.bulan = $('#bulan_proses').val(); 
					e.tahun = $('#tahun_proses').val();
					},
				'url'	: '<?=base_url()?>admin/proses/proses_data_perpajakan/page',
			},
		});

		$("#bulan_proses").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#tahun_proses").change(function() {
			gantiKlien();
			table.draw();
		});
		$("#klien_proses").change(function() {
			table.draw();
		})

		$('#myTable_proses tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		})

		// Detail
		$('#myTable_proses tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>admin/proses/proses_data_perpajakan/detail',
				data: 'id='+ id,
				success: function(data) {
					$(".detailProses").modal('show');
					$(".showProses").html(data);
				}
			})
		});
		
		// Batal
		$('#myTable_proses tbody').on('click', 'a.btn-batal', function() {
			var id = $(this).data('nilai');
			$(".batalProses").modal('show');
			$(".idProses").html( $(this).data('nilai') );
		});
	});
</script>