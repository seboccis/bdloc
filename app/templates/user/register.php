<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>

	<h2>Ceci est la page d'inscription.</h2>
	<div class="container">
		<div class="box box-register">
				
			<form action="" method="POST">
				<div class="form-group">
					<label for="last_name">Nom</label>
					<input type="text" name="last_name" id="last_name" value="<?= $last_name; ?>">
				</div>
				<div class="form-group">
					<label for="first_name">Prénom</label>
					<input type="text" name="first_name" id="first_name" value="<?= $first_name; ?>">
				</div>
				<div class="form-group">
					<label for="username">Pseudo</label>
					<input type="text" name="username" id="username" value="<?= $username; ?>">
					<p class="text-error"><?= $usernameError ?></p>
				</div>
				<div class="form-group">
					<label for="email">email</label>
					<input type="text" name="email" id="email" value="<?= $email; ?>">
					<p class="text-error"><?= $emailError ?></p>
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" id="password">
					
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirmation du mot de passe</label>
					<input type="password" name="confirmPassword" id="confirmPassword">	
					<p class="text-error"><?= $passwordError ?></p>			
				</div>
				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" name="address" id="address" value="<?= $address; ?>">
				</div>
				<div class="form-group">
					<label for="zipcode">Code postal</label>
					<input type="text" name="zip_code" id="zipcode" value="<?= $zip_code; ?>">
					<p class="text-error"><?= $zip_codeError ?></p>
				</div>
				<div class="form-group">
					<label for="phone_number">Numero de téléphone</label>
					<input type="tel" name="phone_number" id="phone_number" value="<?= $phone_number; ?>">
				</div>

				<div class="navigation">
					<button class="btn btn-success">Valider</button>
					<a class="btn btn-danger" href="<?= $this->url('home') ?>">Retour</a>
				</div>

			</form>
		</div>
	</div>
	
<?php $this->stop('main_content') ?>