<div class="content container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	<?php if($this->session->flashdata('warning')) : ?>
		<div class="warning" data-val="yes"></div>
	<?php endif; ?>
	
	<h3 class="mb-3" id="contentTitle"><?= $judul ?></h3>
	
	<div class="card card-shadow">
		<div class="card-header">
			<form action="" method="post">
				<div class="row">
					<div class="col-sm">
						<div class="row form-inline">
							<div class="col">
								<!-- Ganti Bulan -->
								<select name='bulan' class="form-control" id="bulan">
									<?php 
										$bulan = ($this->session->userdata('bulan')) ? $this->session->userdata('bulan') : date('m');
										foreach ($masa as $m) :
											$pilih = ($m['id'] == $bulan) ? "selected" : "";
										?>
									<option value="<?= $m['id']; ?>" <?=$pilih?>> <?= $m['nama'] ?> </option>
									<?php endforeach ?>
								</select>
								
								<!-- Ganti Tahun -->
								<select name='tahun' class="form-control" id="tahun">
									<?php 
										$tahun = $this->session->userdata('tahun') ? $this->session->userdata('tahun') : date('Y');
										for($i=date('Y'); $i>=2010; $i--) :
											$pilih = ($i == $tahun) ? "selected" : "";
										?>
									<option value="<?=$i?>" <?=$pilih?>> <?=$i?> </option>
									<?php endfor ?>
								</select>
								
								<!-- Ganti Klien -->
								<select name='klien' class="form-control" id="klien">
									<option value=""> Semua Klien </option>
								</select> 
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<div class="card-body p-0">
			<table id="myTable" class="table table-striped table-responsive-sm" width=100% style="margin-top:0!important">
				<thead class="text-center">
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Klien</th>
						<th scope="col">ID Permintaan</th>
						<th scope="col">Permintaan</th>
						<th scope="col">Tanggal Permintaan</th>
						<th scope="col">Jumlah Data</th>
						<th scope="col">Status</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
	
				<tbody class="text-center">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Detail Proses -->
<div class="modal fade modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content showDetail">
			<!-- Tampilkan Data -->
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url()?>asset/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		if($('.notification').data('val') == 'yes') {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		if($('.warning').data('val') == 'yes') {
			$('#modalWarning').modal('show');
			//setTimeout(function(){ $('#modalWarning').modal('hide'); },2000);
		}
		
		function klien() {
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/klien',
				data	: {
					'bulan': $('#bulan').val(),
					'tahun': $('#tahun').val(),
				},
				success	: function(data) {
					$("#klien").html(data);
				}
			})
		}
		klien();
		
		// $.fn.dataTable.ext.buttons.reload = {
		// 	text: 'Coba',
		// 	action: function ( e, dt, node, config ) {
		// 		var data = dt.ajax.params();
		// 		// alert( 'Search term was: '+data.search.value );
		// 		$.ajax({
		// 			type	: 'POST',
		// 			url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/export',
		// 			data	: {
		// 				'bulan': data.bulan,
		// 				'tahun': data.tahun,
		// 				'klien': data.klien,
		// 			},
		// 			success	: function(e) {
		// 				var result = JSON.parse(e)
		// 				alert('Result : '+result);
		// 			}
		// 		})
		// 	}
		// };
		
		var table = $('#myTable').DataTable({
			'processing'	: true,
			'serverSide'	: true,
			'ordering'		: false,
			'lengthChange'	: false,
			'searching'		: false,
			'pageLength'	: 1,
			'language'		: {
				emptyTable	: "Belum ada pengiriman"
			},
			'ajax'		: {
				'url'	: '<?=base_url()?>akuntan/pengiriman_data_akuntansi/page',
				'type'	: 'post',
				'data'	: function (e) { 
					e.klien = $('#klien').val(); 
					e.bulan = $('#bulan').val(); 
					e.tahun = $('#tahun').val();
				},
			},
			'columnDefs'	: [ 
				{
					className: "align-top",
					targets: "_all" },
				{
					'targets'	: 2,
					'visible'	: false,
				},
			],
			// 'dom'			: 'Bfrtip',
			// 'buttons'		: [
			// 	{
			// 		extend: 'excel',
			// 		text: 'Export Excel',
			// 		title: function() { return $('#contentTitle').html() },
			// 		filename: function() { return $('#contentTitle').html() },
			// 	},
			// 	{
			// 		extend: 'pdf',
			// 		text: 'Export PDF',
			// 		orientation: 'landscape',
			// 		title: function() { return $('#contentTitle').html() },
			// 		filename: function() { return $('#contentTitle').html() },
			// 		customize: function (doc) {
			// 			var now = new Date();
			// 			var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear()+' '+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
			// 			// doc.defaultStyle.fontSize = 7;
			// 			doc['footer']=(function(page, pages) {
			// 				return {
			// 					columns: [
			// 						{
			// 							alignment: 'left',
			// 							text: ['Created on: ', { text: jsDate.toString() }]
			// 						},
			// 						{
			// 							alignment: 'right',
			// 							text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
			// 						}
			// 					],
			// 					margin: 20
			// 				}
			// 			});
			// 		},
			// 		exportOptions : {
			// 			modifier : {
			// 				page : 'all',
			// 			}
			// 		}
			// 	},
			// 	{
			// 		extend: 'print',
			// 		exportOptions : {
			// 			modifier : {
			// 				page : 'all',
			// 			}
			// 		}
			// 	},
			// ],
		});
		
		// new $.fn.dataTable.Buttons( table, {
		// 	buttons: [
		// 		{
		// 			extends : 'reload',
		// 			text: 'Create CSV',
		// 			action: function ( e, dt, node, config ) {
		// 				// Do custom processing
		// 				var data = dt.ajax.params();
						
		// 				$.ajax({
		// 					type	: 'POST',
		// 					url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/export',
		// 					data	: {
		// 						'bulan': data.bulan,
		// 						'tahun': data.tahun,
		// 						'klien': data.klien,
		// 					},
		// 					success	: function(e) {
		// 						var result = JSON.parse(e)
		// 						alert('Result : '+result);
		// 					}
		// 				})
		// 				// Call the default csvHtml5 action method to create the CSV file
		// 				$.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, node, config);
		// 			}
		// 		}
		// 	]
		// } );
		
		$("#bulan").change(function() {
			klien();
			table.draw();
		});
		$("#tahun").change(function() {
			klien();
			table.draw();
		});
		$("#klien").change(function() {
			table.draw();
		});
		
		$('#myTable tbody').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		
		// Detail Permintaan
		$('#myTable tbody').on('click', 'a.btn-detail', function() {
			var id = $(this).data('nilai');
			$.ajax({
				type	: 'POST',
				url		: '<?= base_url(); ?>akuntan/pengiriman_data_akuntansi/detail',
				data	: 'id='+ id,
				success	: function(data) {
					$(".modalDetail").modal('show');
					$(".showDetail").html(data);
				}
			})
		});
	});
</script>
