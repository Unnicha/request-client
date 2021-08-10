<div class="container-fluid">
	<div class="row px-3">
		<div class="col">
			<h3><?= $judul ?></h3>
		</div>
	</div>
	
	<hr class="my-0">
	
	<div class="row row-child my-3">
		<div class="col">
			<form action="" method="post">
				<input type="hidden" name="id_user" value="<?=$this->session->userdata('id_user')?>">
				
				<!-- Klien -->
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama Klien</label>
					<div class="col-sm col-md-4 p-0">
						<select name='id_klien' class="form-control" id="id_klien" required>
								<option value="">--Pilih Klien--</option>
							<?php foreach ($klien as $k) : ?>
								<option value="<?= $k['id_klien']; ?>"><?= $k['nama_klien']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Data</label>
				</div>
				
				<div class="data px-3">
					<div class="add-after form-row mb-3">
						<div class="col">
							<div class="form-row">
								<!-- Jenis Data -->
								<div class="col-md">
									<select name="kode_jenis[]" class="form-control" required>
										<option value="" selected>--Pilih Jenis Data--</option>
											<?php foreach ($jenis as $j) : ?>
										<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
											<?php endforeach ?>
									</select>
								</div>
								
								<!-- Keterangan -->
								<div class="col-md">
									<input type="text" name="detail[]" class="form-control" placeholder="Detail">
								</div>
								
								<!-- Format Data -->
								<div class="col-md">
									<select name="format_data[]" class="form-control" required>
										<option value="" selected>--Pilih Format Data--</option>
										<option value="Softcopy">Softcopy</option>
										<option value="Hardcopy">Hardcopy</option>
									</select>
								</div>
							</div>
						</div>
						<div class="span py-1">
							<a class="btn btn-sm btn-success add-data" data-toggle="tooltip" data-placement="bottom" title="Tambah">
								<i class="bi bi-plus"></i>
							</a>
						</div>
					</div>
				</div>
				
				<!-- Tombol Simpan -->
				<div class="row my-4">
					<div class="col">
						<button type="submit" name="tambah" class="btn btn-primary">Kirim</button>
						<a href="<?= base_url() ?>admin/permintaan/permintaan_data_akuntansi" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
			
			<div class="clone invisible">
				<div class="control-group form-row mb-3">
					<div class="col">
						<div class="form-row">
							<!-- Jenis Data -->
							<div class="col-md">
								<select name="kode_jenis[]" class="form-control" required>
									<option value="" selected>--Pilih Jenis Data--</option>
										<?php foreach ($jenis as $j) : ?>
									<option value="<?= $j['kode_jenis']; ?>"><?= $j['jenis_data']; ?></option>
										<?php endforeach ?>
								</select>
							</div>
							
							<!-- Keterangan -->
							<div class="col-md">
								<input type="text" name="detail[]" class="form-control" placeholder="Detail">
							</div>
							
							<!-- Format Data -->
							<div class="col-md">
								<select name="format_data[]" class="form-control" required>
									<option value="" selected>--Pilih Format Data--</option>
									<option value="Softcopy">Softcopy</option>
									<option value="Hardcopy">Hardcopy</option>
								</select>
							</div>
						</div>
					</div>
					<div class="span py-1">
						<a class="btn btn-sm btn-outline-danger remove-data" data-toggle="tooltip" data-placement="bottom" title="Hapus">
							<i class="bi bi-trash"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.data').on('mouseover', '[data-toggle="tooltip"]', function() {
			$(this).tooltip();
		});
		
		$(".add-data").click(function() {
			var html = $(".clone").html();
			$(".add-after:last-child").after(html);
			$('.data .control-group').addClass('add-after');
		});
		
		// saat tombol remove dklik control group akan dihapus
		$("body").on("click", ".remove-data", function() {
			$(this).parents(".control-group").remove();
		});
	})
</script>