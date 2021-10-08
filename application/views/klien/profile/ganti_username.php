<div class="content container-fluid">
	<h3 class="content-header"><?=$judul?></h3>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-round card-shadow">
				<div class="card-body" style="padding: 2rem">
					<form action="" method="post">
						<input type="hidden" name="tipe" value="<?=$tipe?>">
						<input type="hidden" name="table" value="<?=$table?>">
						<input type="hidden" name="id_klien" value="<?=$klien['id_klien']?>">
						
						<?php $value = (set_value('username')) ? set_value('username') : $klien['username']; ?>
						<div class="form-group row">
							<div class="col">
								<label for="username" class="form-label">Masukkan Username</label>
								<input type="text" name="username" class="form-control" value="<?=$value?>" placeholder="Username" required>
								<small class="form-text text-danger"><?= form_error('username', '<p class="mb-0">', '</p>') ?></small>
								<small class="form-text text-danger"><?= $this->session->flashdata('used') ?></small>
							</div>
						</div>
						
						<div class="row mt-4 text-right">
							<div class="col">
								<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
								<a href="<?=base_url() . $back?>" class="btn btn-secondary">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
