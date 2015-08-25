<?php $this->layout('layout', ['title' => 'Accueil !']) ?>

<?php $this->start('main_content') ?>
	<h2>Let's code.</h2>

	<a href="<?= $this->url('login')?>">Connectez-vous</a>
	<a href="<?= $this->url('register')?>">Créer un compte</a>
	
<?php $this->stop('main_content') ?>
