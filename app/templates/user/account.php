<?php $this->layout('main_layout', ['title' => 'Informations personnelles']) ?>

<?php $this->start('main_content') ?>

	<h2>Ceci est la page du compte</h2>

	<div id="sideBar" class="navbarAccount">
		<nav>
			<a href="<?php echo $this->url('account')?>">Mes informations</a>
			<a href="<?php echo $this->url('edit_profile')?>">Modifier mes informations personnelles</a>
			<a href="<?php echo $this->url('edit_password')?>">Modifier mon mot de passe</a>
			<a href="#">Consulter mon historique de locations</a>
			<a href="#">Payer une amende</a>
			<a href="#">Me désabonner</a>
		</nav>
	</div>

	<div id="content">
		<p>Prénom : <?= $w_user['first_name'] ?></p>
		<p>Nom : <?= $w_user['last_name'] ?></p>
		<p>Pseudo : <?= $w_user['username'] ?></p>
		<p>Email : <?= $w_user['email']?></p>
		<p>Adresse : <?= $w_user['address'] ?></p>
		<p>Code postal : <?= $w_user['zip_code'] ?></p>
		<p>Numéro de téléphone : <?= $w_user['phone_number'] ?></p>
	</div>
		
<?php $this->stop('main_content') ?>