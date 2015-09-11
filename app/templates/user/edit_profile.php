<?php $this->layout('main_layout', ['title' => 'Modifier le profile']) ?>

<?php $this->start('main_content') ?>


	<h2>Ceci est la page de modification.</h2>

	<div id="sideBar" class="navbarAccount">
		<nav>
			<a href="<?php echo $this->url('account')?>">Mes informations</a>
			<a href="<?php echo $this->url('edit_profile')?>">Modifier mes informations personnelles</a>
			<a href="<?php echo $this->url('edit_password')?>">Modifier mon mot de passe</a>
			<a href="<?php echo $this->url('order_history')?>">Consulter mon historique de locations</a>
			<a href="#">Payer une amende</a>
			<a href="#">Me désabonner</a>
		</nav>
	</div>

	<div id="content">
		<form action="" method="POST">
			<fieldset>
				<legend>Modification des informations</legend>
				<div class="form-row">
					<label for="last_name">Nom</label>
					<input type="text" name="last_name" id="last_name" value="<?= $this->e($w_user['last_name']) ?>">
				</div>
				<div class="form-row">
					<label for="first_name">Prénom</label>
					<input type="text" name="first_name" id="first_name" value="<?= $this->e($w_user['first_name']) ?>">
				</div>
				<div class="form-row">
					<label for="username">Pseudo</label>
					<input type="text" name="username" id="username" value="<?= $this->e($w_user['username']) ?>">
					<p><?= $usernameError ?></p>
				</div>
				<div class="form-row">
					<label for="email">email</label>
					<input type="text" name="email" id="email" value="<?= $this->e($w_user['email']) ?>">
					<p><?= $emailError ?></p>
				</div>
				<div class="form-row">
					<label for="address">Adresse</label>
					<input type="text" name="address" id="address" value="<?= $this->e($w_user['address']) ?>">
				</div>
				<div class="form-row">
					<label for="zipcode">Code postal</label>
					<input type="text" name="zip_code" id="zipcode" value="<?= $this->e($w_user['zip_code']) ?>">
					<p><?= $zip_codeError ?></p>
				</div>
				<div class="form-row">
					<label for="phone_number">Numero de téléphone</label>
					<input type="tel" name="phone_number" id="phone_number" value="<?= $this->e($w_user['phone_number']) ?>">
				</div>
			</fieldset>

			<button>Valider</button>

		</form>
	</div>
	
<?php $this->stop('main_content') ?>