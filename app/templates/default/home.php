<?php $this->layout('layout', ['title' => 'Accueil !']) ?>

<?php $this->start('main_content') ?>

	<h1>Le site de locations de BDs, fait par des parisiens pour des parisiens...</h1>
		
	<div class="box box-home">
	<p>Page de connexion</p>
		<div class="navigation">
			<a class="btn btn-success" href="<?= $this->url('login')?>">Connectez-vous</a>
			<a class="btn btn-info" href="<?= $this->url('register')?>">S'inscrire</a>
		</div>
	</div>
	
<?php $this->stop('main_content') ?>
