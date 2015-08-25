<?php $this->layout('layout', ['title' => 'Informations personnelles']) ?>

<?php $this->start('main_content') ?>

	<nav>
		<a href="<?php echo $this->url('catalog');?>">Catalogue</a>
		<a href="<?php echo $this->url('account');?>">Mon Compte</a>
		<a href="#">Panier</a>
	</nav>

	<h2>Ceci est la page du compte</h2>

	<nav>
		<a href="#">Mes informations</a>
		<a href="#">Modifier mes informations personnelles</a>
		<a href="#">Modifier mon mot de passe</a>
		<a href="#">Consulter mon historique de locations</a>
		<a href="#">Payer une amende</a>
		<a href="#">Me désabonner</a>
	</nav>

	<p>Prénom : <?= $first_name?></p>
	<p>Nom : <?= $last_name?></p>
	<p>Email : <?= $username ?></p>
	<p>Pseudo : <?= $email?></p>
	<p>Adresse : <?= $address ?></p>
	<p>Code postal : <?= $zip_code ?></p>
	<p>Numéro de téléphone : <?= $phone_number ?></p>


	
<?php $this->stop('main_content') ?>