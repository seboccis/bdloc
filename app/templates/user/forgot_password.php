<?php $this->layout('layout', ['title'=>'forgot_password']) ?>

<?php $this->start('main_content') ?>
	<h2>Mot de passe oublié</h2>

	<div class="box box-login">

		<form action="" method="post">
			<div class="form-group">
				<label for="email">Votre email</label>
					<input type="email" name="email" id="email">
					<div class="help-block text-danger"><?= $this->e($errorEmail) ?></div>
			</div>

			<div class="navigation">
				<input class="btn btn-success" type="submit" value="Evoyer l'email">
				<a class="btn btn-danger" href="<?= $this->url('home') ?>">Retour</a>
			</div>

		</form>
	</div>
	
<?php $this->stop('main_content') ?>