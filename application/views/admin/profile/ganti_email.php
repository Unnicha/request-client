<div class="container-fluid">
	<div class="row">
		<div class="col">
			<h3 class="px-3"><?=$judul?></h3>
		</div>
	</div>
	
	<hr class="my-0">
	
	<div class="row mt-3">
		<div class="col col-profile">
			<form action="" method="post"> 
				<input type="hidden" name="id_user" id="id_user" value="<?= $admin['id_user'] ?>">
				
				<div class="form-group row">
					<div class="col">
						<label for="email" class="form-label">Masukkan Email Baru</label>
						<input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
						<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
						<?php if($this->session->flashdata('email')) : ?>
							<small class="form-text text-danger">
								<?= $this->session->flashdata('email'); ?>
							</small>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col">
						<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
						<a href="<?= base_url(); ?>admin/profile" class="btn btn-secondary">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>