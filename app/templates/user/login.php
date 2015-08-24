<?php $this->layout('layout', ['title' => 'Login']) ?>

<?php $this->start('main_content') ?>
	<h2>Ceci est la page de login.</h2>

		<form action="" method="POST">
			<div class="form-row">
				<label for="">Pseudo</label>
				<input type="text" name="username" id="username">
			</div>
			<div class="form-row">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password">
			</div>
			
			<button>Valider</button>

			<div><?php echo $error; ?></div>

		</form>
	
<?php $this->stop('main_content') ?>