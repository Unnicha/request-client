<div class="content container-fluid">
	<h3 class="content-header"><?=$judul?></h3>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-round card-shadow">
				<div class="card-body" style="padding: 2rem">
					<form action="" method="post"> 
						<input type="hidden" name="id_user" id="id_user" value="<?= $admin['id_user'] ?>">
						<input type="hidden" name="tipe" id="tipe" value="email">
						
						<?php $value = (set_value('email')) ? set_value('email') : $admin['email_user']; ?>
						<div class="form-group row">
							<div class="col">
								<label class="form-label blockquote">Masukkan Email</label>
								<input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?=$value?>" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<div class="row mt-4 text-right">
							<div class="col">
								<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
								<a href="<?= base_url(); ?>admin/profile" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
