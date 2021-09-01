<div class="content container-fluid">
	<div class="row mb-2">
		<div class="col">
			<h3><?=$judul?></h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-round">
				<div class="card-body p-4">
					<form action="" method="post"> 
						<input type="hidden" name="level" id="level" value="<?= $level ?>">
						
						<!-- Nama User -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Nama</label>
							<div class="col-sm">
								<input type="text" name="nama" class="form-control" id="nama" value="<?= set_value('nama') ?>" required autofocus>
								<small class="form-text text-danger"><?= form_error('nama', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Email User -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Email</label> 
							<div class="col-sm">
								<input type="text" name="email" class="form-control" id="email" value="<?= set_value('email') ?>" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Username -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Username</label>
							<div class="col-sm">
								<input type="text" name="username" class="form-control" id="username" value="<?= set_value('username') ?>" required>
								<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
						
						<!-- Password -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Password</label>
							<div class="col-sm">
								<input type="password" name="password" class="form-control" id="password" required>
								<small class="form-text text-danger"><?= form_error('password', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
		
						<!-- Konfirmasi Password -->
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Konfirmasi</label>
							<div class="col-sm">
								<input type="password" name="passconf" class="form-control" id="passconf" required>
								<small class="form-text text-danger"><?= form_error('passconf', '<p class="mb-0">', '</p>') ?></small>
							</div>
						</div>
					
						<div class="row mt-3 text-right">
							<div class="col">
								<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
								<a href="<?=base_url()?>admin/master/admin" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>