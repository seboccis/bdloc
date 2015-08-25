<?php $this->layout('catalog_layout', ['title' => 'Modifier le profile']) ?>

<?php $this->start('main_content') ?>


	<h2>Ceci est la page de modification.</h2>

	<nav>
		<a href="<?php echo $this->url('account')?>">Mes informations</a>
		<a href="<?php echo $this->url('edit_profile')?>">Modifier mes informations personnelles</a>
		<a href="<?php echo $this->url('edit_password')?>">Modifier mon mot de passe</a>
		<a href="#">Consulter mon historique de locations</a>
		<a href="#">Payer une amende</a>
		<a href="#">Me désabonner</a>

	</nav>

	<div class="container">
		<form action="" method="POST">
			<div class="form-row">
				<label for="old_password">Ancien mot de passe</label>
				<input type="password" name="old_password" id="old_password">
				<p><?= $old_passwordError ?></p>
			</div>
			<div class="form-row">
				<label for="password">Nouveau mot de passe</label>
				<input type="password" name="password" id="password">	
			</div>

			<div class="form-row">
				<label for="confirmPassword">Confirmation du nouveau mot de passe</label>
				<input type="password" name="confirmPassword" id="confirmPassword">	
				<p><?= $passwordError ?></p>			
			</div>


			<button>Valider</button>

		</form>
	</div>
	
<?php $this->stop('main_content') ?>