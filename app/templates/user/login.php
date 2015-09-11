<?php $this->layout('layout', ['title' => 'Login']) ?>

<?php $this->start('main_content') ?>
	

	<div class="navigation navigation-login">
		
		<form action="" method="POST">
			<div class="form-group">
				<label for="">Pseudo</label>
				<input type="text" name="username" id="username">
				<p class="text-error"><?= $this->e($error) ?>
			</div>
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password">
			</div>
			<div class="form-group">
				<a href="<?= $this->url('forgot_password') ?>">Mot de passe oublié</a>
			</div>
			
			<div class="link">
				
				<button class="btn btn-success">Valider</button>
			
				<a class="btn btn-danger" href="<?= $this->url('home') ?>">Retour</a>

			</div>

		</form>

	</div>
		
	
<?php $this->stop('main_content') ?>