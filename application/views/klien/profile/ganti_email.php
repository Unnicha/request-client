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
						
						<?php $value = (set_value('email')) ? set_value('email') : $klien['email_user']; ?>
						<div class="form-group row">
							<div class="col">
								<label for="email" class="form-label">Masukkan Email</label>
								<input type="text" name="email" class="form-control" value="<?=$value?>" placeholder="Email" required>
								<small class="form-text text-danger"><?= form_error('email', '<p class="mb-0">', '</p>') ?></small>
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
