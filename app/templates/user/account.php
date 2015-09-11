<?php $this->layout('main_layout', ['title' => 'Informations personnelles']) ?>

<?php $this->start('main_content') ?>

	<h2>Ceci est la page du compte</h2>

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
		<p>Prénom : <?= $this->e($w_user['first_name']) ?></p>
		<p>Nom : <?= $this->e($w_user['last_name']) ?></p>
		<p>Pseudo : <?= $this->e($w_user['username']) ?></p>
		<p>Email : <?= $this->e($w_user['email']) ?></p>
		<p>Adresse : <?= $this->e($w_user['address']) ?></p>
		<p>Code postal : <?= $this->e($w_user['zip_code']) ?></p>
		<p>Numéro de téléphone : <?= $this->e($w_user['phone_number']) ?></p>
	</div>
		
<?php $this->stop('main_content') ?>