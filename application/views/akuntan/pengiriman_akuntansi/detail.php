<div class="container-fluid">
	<?php if($this->session->flashdata('notification')) : ?>
		<div class="notification" data-val="yes"></div>
	<?php endif; ?>
	
	<h2 class="text-center"><?= $judul ?></h2>
	
	<hr class="my-0">
	
	<div class="row row-child mt-2 mb-3">
		<div class="col">
			<div class="row">
				<div class="col">
					<table class="table table-borderless" style="width:fit-content">
						<tbody>
							<tr>
								<td>Jenis Data</td>
								<td> : <?=$detail['jenis_data']?></td>
							</tr>
							<tr>
								<td>Detail</td>
								<td> : <?=$detail['detail']?></td>
							</tr>
							<tr>
								<td>Format Data</td>
								<td> : <?=$detail['format_data']?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td> : <?= $detail['badge'] ?></td>
							</tr>
							<tr>
								<td>Action</td>
								<td> : 
									<?= $detail['button'] ?>
									<a href="<?=base_url('akuntan/pengiriman_data_akuntansi')?>" class="btn btn-secondary mr-1">Kembali</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<table class="table table-sm table-striped table-bordered">
						<thead class="text-center">
							<tr>
								<th>Pengiriman ke</th>
								<th>Tanggal pengiriman</th>
								<th><?= $detail['format_data'] == 'Softcopy' ? 'File' : 'Tanggal Ambil' ?></th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody class="text-center">
							<?php
								if($pengiriman) :
									foreach($pengiriman as $p) : ?>
							<tr>
								<td><?=$p['pengiriman']?></td>
								<td><?=$p['tanggal_pengiriman']?></td>
								<td><?=$p['file']?></td>
								<td class="text-left"><?=$p['ket_pengiriman']?></td>
							</tr>
								<?php endforeach; else : ?>
							<tr>
								<td colspan="5">Belum ada pengiriman</td>
							</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalKonfirm" tabindex="0" aria-labelledby="konfirmLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content mx-auto" id="konfirmShow" style="width:400px">
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		if( $('.notification').data('val') == 'yes' ) {
			$('#modalNotif').modal('show');
			setTimeout(function(){ $('#modalNotif').modal('hide'); },2000);
		}
		
		$('[data-toggle="tooltip"]').mouseenter(function() {
			$(this).tooltip();
		});
		
		$('.btn-konfirm').click(function() {
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>akuntan/permintaan_data_akuntansi/konfirmasi',
				data	: {
					'id'		: $(this).data('id'),
					'status'	: $(this).data('status'),
				},
				success	: function( e ) {
					$('#modalKonfirm').modal('show');
					$('#konfirmShow').html( e );
				}
			})
		})
		$('#konfirmShow').on('click', '.btn-fix', function() {
			var id		= $(this).data('id');
			var stat	= $(this).data('status');
			$.ajax({
				type	: 'post',
				url		: '<?= base_url(); ?>akuntan/permintaan_data_akuntansi/fix',
				data	: {
					'id'	: id,
					'stat'	: stat
				},
				success	: function() {
					$('#modalKonfirm').modal('hide');
					window.location.assign("<?= base_url();?>akuntan/pengiriman_data_akuntansi/detail/"+id);
				}
			})
		})
	})
</script>