<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>

	<div class="container">
		<div class="navigation navigation-register">
				
			<form action="" method="POST">
				<div class="form-group">
					<label for="last_name">Nom</label>
					<input type="text" name="last_name" id="last_name" value="<?= $this->e($last_name) ?>">
				</div>
				<div class="form-group">
					<label for="first_name">Prénom</label>
					<input type="text" name="first_name" id="first_name" value="<?= $this->e($first_name) ?>">
				</div>
				<div class="form-group">
					<label for="username">Pseudo</label>
					<input type="text" name="username" id="username" value="<?= $this->e($username) ?>">
					<p class="text-error"><?= $usernameError ?></p>
				</div>
				<div class="form-group">
					<label for="email">email</label>
					<input type="text" name="email" id="email" value="<?= $this->e($email) ?>">
					<p class="text-error"><?= $emailError ?></p>
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" id="password">
					
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirmation du mot de passe</label>
					<input type="password" name="confirmPassword" id="confirmPassword">	
					<p class="text-error"><?= $this->e($passwordError) ?></p>			
				</div>
				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" name="address" id="address" value="<?= $this->e($address) ?>">
				</div>
				<div class="form-group">
					<label for="zipcode">Code postal</label>
					<input type="text" name="zip_code" id="zipcode" value="<?= $this->e($zip_code) ?>">
					<p class="text-error"><?= $zip_codeError ?></p>
				</div>
				<div class="form-group">
					<label for="phone_number">Numero de téléphone</label>
					<input type="tel" name="phone_number" id="phone_number" value="<?= $this->e($phone_number) ?>">
				</div>

				<div class="link">
					<button class="btn btn-success">Valider</button>
					<a class="btn btn-danger" href="<?= $this->url('home') ?>">Retour</a>
				</div>

			</form>
		</div>
	</div>
	
<?php $this->stop('main_content') ?>