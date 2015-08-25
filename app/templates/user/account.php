<?php $this->layout('catalog_layout', ['title' => 'Informations personnelles']) ?>

<?php $this->start('main_content') ?>
<?php debug($w_user) ?>

	<h2>Ceci est la page du compte</h2>

	<nav>
		<a href="#">Mes informations</a>
		<a href="#">Modifier mes informations personnelles</a>
		<a href="#">Modifier mon mot de passe</a>
		<a href="#">Consulter mon historique de locations</a>
		<a href="#">Payer une amende</a>
		<a href="#">Me désabonner</a>

	</nav>

	<p>Prénom : <?= $w_user['first_name'] ?></p>
	<p>Nom : <?= $w_user['last_name'] ?></p>
	<p>Pseudo : <?= $w_user['username'] ?></p>
	<p>Email : <?= $w_user['email']?></p>
	<p>Adresse : <?= $w_user['address'] ?></p>
	<p>Code postal : <?= $w_user['zip_code'] ?></p>
	<p>Numéro de téléphone : <?= $w_user['phone_number'] ?></p>


	
<?php $this->stop('main_content') ?>