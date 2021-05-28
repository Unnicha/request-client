<div class="container-fluid">
	<!-- Judul Form -->
	<div class="row row-child">
		<div class="col">
			<h2 class="mb-2"><?= $judul; ?></h2>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mt-3">
		<div class="col col-proses">
			<!-- Notifikasi -->
			<?php if($this->session->flashdata('flash')) : ?>
				<div class="row">
					<div class="col">
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('flash'); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- Isi Form -->
			<form action="" method="post"> 
				<input type="hidden" id="id_proses" name="id_proses" value="<?=$pengiriman['id_proses']?>">

				<!-- Klien -->
				<div class="form-group row">
					<label for="id_klien" class="col-sm-3 col-form-label">Klien</label> 
					<div class="col-sm">
						<input type="text" name="nama_klien" class="form-control" id="nama_klien" value="<?=$pengiriman['nama_klien']?>" readonly>
					</div>
				</div>

				<!-- Jenis Data -->
				<div class="form-group row">
					<label for="jenis_data" class="col-sm-3 col-form-label">Jenis Data</label> 
					<div class="col-sm">
						<input type="text" name="jenis_data" class="form-control" id="jenis_data" value="<?=$pengiriman['jenis_data']?>" readonly>
					</div>
				</div>

				<!-- Output -->
				<div class="form-group row">
					<label for="nama_tugas" class="col-sm-3 col-form-label">Output</label> 
					<div class="col-sm">
						<input type="text" name="nama_tugas" class="form-control" id="nama_tugas" value="<?=$pengiriman['nama_tugas']?>" readonly>
					</div>
				</div>

				<!-- Masa -->
				<div class="form-group row">
					<label for="masa" class="col-sm-3 col-form-label">Masa</label> 
					<div class="col-sm pr-0">
						<input type="text" name="masa" class="form-control" id="masa" value="<?=$pengiriman['masa']?>" readonly>
					</div>
					<div class="col-sm">
						<input type="text" name="tahun" class="form-control" id="tahun" value="<?=$pengiriman['tahun']?>" readonly>
					</div>
				</div>

				<!-- Permintaan -->
				<div class="form-group row">
					<label for="pembetulan" class="col-sm-3 col-form-label">Permintaan ke</label> 
					<div class="col-sm">
						<input type="text" name="pembetulan" class="form-control" id="pembetulan" value="<?=$pengiriman['request']?>" readonly>
					</div>
				</div>

				<!-- Pengiriman -->
				<div class="form-group row">
					<label for="pembetulan" class="col-sm-3 col-form-label">Pengiriman ke</label> 
					<div class="col-sm">
						<input type="text" name="pembetulan" class="form-control" id="pembetulan" value="<?=($pengiriman['pembetulan'] + 1)?>" readonly>
					</div>
				</div>
				
				<!-- Mulai Proses -->
				<div class="form-group row">
					<label for="tanggal_mulai" class="col-sm-3 col-form-label"> Mulai Proses </label> 
					<!-- Tanggal Mulai -->
					<div class="col-sm pr-0">
						<input type="text" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="<?=$pengiriman['tanggal_mulai']?>" readonly>
					</div>
					<!-- Jam Mulai -->
					<div class="col-sm">
						<input type="text" name="jam_mulai" class="form-control" id="jam_mulai" value="<?=$pengiriman['jam_mulai']?>" readonly>
					</div>
				</div>

				<!-- Selesai Proses -->
				<div class="form-group row">
					<label for="tanggal_selesai" class="col-sm-3 col-form-label"> Selesai Proses </label> 
					<div class="col-sm pr-0">
						<input type="text" name="tanggal_selesai" class="form-control docs-date" id="tanggal_selesai" placeholder="Tanggal Selesai" data-toggle="datepicker">
						<small class="form-text text-danger"><?= form_error('tanggal_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
					<div class="col-sm">
						<input type="text" name="jam_selesai" class="form-control bs-timepicker" id="jam_selesai" placeholder="Jam Selesai">
						<small class="form-text text-danger"><?= form_error('jam_selesai', '<p class="mb-0">', '</p>') ?></small>
					</div>
				</div>

				<!-- Keterangan -->
				<div class="form-group row">
					<label for="keterangan3" class="col-sm-3 col-form-label">Keterangan</label> 
					<div class="col-sm">
						<input type="text" name="keterangan3" class="form-control" id="keterangan3" value="<?= $pengiriman['keterangan3'] ?>">
					</div>
				</div>
				
				<!-- Tombol Simpan -->
				<div class="row my-3 text-right">
					<div class="col p-0">
						<button type="submit" name="tambah" class="btn btn-primary mr-1">
							Selesai
						</button>
						<a href="<?= base_url(); ?>akuntan/proses_data_perpajakan" class="btn btn-secondary mr-3">
							Batal
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/timepicker-tiny.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>
<script>
	//memanggil date picker
	const myDatePicker = $('[data-toggle="datepicker"]').datepicker({
		autoHide: true,
		format: 'dd/mm/yyyy',
	});

	//memanggil time picker
	$('.bs-timepicker').timepicker();
</script>
