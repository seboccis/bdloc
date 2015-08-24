<?php $this->layout('layout', ['title' => 'Inscription']) ?>

<?php $this->start('main_content') ?>
	<h2>Ceci est la page d'inscription.</h2>
	<div class="container">
		<form action="" method="POST">
			<div class="form-row">
				<label for="last_name">Nom</label>
				<input type="text" name="last_name" id="last_name">				
			</div>
			<div class="form-row">
				<label for="first_name">Prenom</label>
				<input type="text" name="first_name" id="first_name">
			</div>
			<div class="form-row">
				<label for="username">Pseudo</label>
				<input type="text" name="username" id="username">				
			</div>
			<div class="form-row">
				<label for="email">email</label>
				<input type="text" name="email" id="email">				
			</div>
			<div class="form-row">
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password">
			</div>
			<div class="form-row">
				<label for="confirmPassword">Confirmation du mot de passe</label>
				<input type="password" name="confirmPassword" id="confirmPassword">				
			</div>
			<div class="form-row">
				<label for="address">Adresse</label>
				<input type="text" name="address" id="address">
			</div>
			<div class="form-row">
				<label for="zipcode">Code postal</label>
				<input type="text" name="zip_code" id="zipcode">
			</div>
			<div class="form-row">
				<label for="phoneNumber">Numero de téléphone</label>
				<input type="tel" name="phoneNumber" id="phoneNumber">
			</div>


			<button>Valider</button>

			<div><?php echo $error; ?></div>

		</form>
	</div>
	
<?php $this->stop('main_content') ?>