<div class="container-fluid">
	<div class="row row-child">
		<div class="col">
			<h3 class="mb-3"><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">

	<div class="row row-child mb-3">
		<div class="col px-lg-4">
			<form action="" method="post">
				<input type="hidden" name="id_permintaan" value="<?=$id_permintaan?>">
				
				<?php $num=0; foreach($isi as $i) : ?>
				<input type="hidden" name="id_data[]" value="<?=$i['id_data']?>">
				<div class="form-row pt-1 mt-2">
					<label class="col-form-label pt-0"><b><?= $num + 1 ?>.</b></label>
					
					<div class="col col-lg-5">
						<div class="form-row mb-2">
							<div class="col-4">Jenis Data</div>
							<div class="col">: <?=$i['jenis_data']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Detail</div>
							<div class="col">: <?=$i['detail']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">Format Data</div>
							<div class="col">: <?=$i['format_data']?></div>
						</div>
						<div class="form-row my-2">
							<div class="col-4"><?=$add[$num]['file_title']?></div>
							<div class="col">: <?=$add[$num]['file']?></div>
						</div>
					</div>
					
					<?php 
						$lengkap	= ($i['status'] == 3) ? 'checked' : '';
						$kurang		= ($i['status'] == 2) ? 'checked' : '';
						$belum		= ($i['status'] == 1) ? 'checked' : '';
					?>
					<div class="col col-lg-5">
						<div class="form-row">
							<label for="klien" class="col-form-label pr-3 py-0">Status :</label> 
							<div class="col-sm">
								<div class="form-check mb-2">
									<input class="form-check-input" type="radio" name="status[<?=$num?>]" id="lengkap[<?=$num?>]" value="3" <?=$lengkap?>>
									<label class="form-check-label" for="lengkap[<?=$num?>]">Lengkap</label>
								</div>
								<div class="form-check mb-2">
									<input class="form-check-input" type="radio" name="status[<?=$num?>]" id="kurang[<?=$num?>]" value="2" <?=$kurang?>>
									<label class="form-check-label" for="kurang[<?=$num?>]">Kurang Lengkap</label>
								</div>
								<div class="form-check mb-2" style="display:none">
									<input class="form-check-input" type="radio" name="status[<?=$num?>]" id="belum[<?=$num?>]" value="1" <?=$belum?>>
									<label class="form-check-label" for="belum[<?=$num?>]">Kosong</label>
								</div>
							</div>
						</div>
						
						<div class="form-row mt-2 mb-3">
							<div class="col">
								<textarea type="text" name="keterangan2[]" class="form-control" style="height:calc(1.5em + .75rem + 2px)" placeholder="Keterangan"><?=$i['ket_status']?></textarea>
							</div>
						</div>
					</div>
				</div>
				
				<hr class="my-0">
				<?php $num++; endforeach ?>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary">Kirim</button>
						<a href="<?= base_url(); ?>akuntan/penerimaan_data_perpajakan" class="btn btn-secondary">Batal</a>
						<button type="reset" name="reset" class="btn btn-outline-secondary">Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>asset/js/bs-custom-file-input.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>asset/js/datepicker.en-us.js"></script>
<script>
	$(document).ready(function () {
		bsCustomFileInput.init();
		
		//memanggil date picker
		const myDatePicker = $('[data-toggle="datepicker"]').datepicker({
			autoHide: true,
			format: 'dd-mm-yyyy',
		});
	})
</script>