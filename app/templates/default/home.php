<?php $this->layout('layout', ['title' => 'Accueil !']) ?>

<?php $this->start('main_content') ?>

	<h1>Le site de locations de BDs, fait par des parisiens pour des parisiens...</h1>
		
	<div class="box box-home">
	
		<div class="navigation navigation-home">
			<h2>Connexion</h2>
			<div class="link">
				<a class="btn btn-success" href="<?= $this->url('login')?>">Connectez-vous</a>
				<a class="btn btn-info" href="<?= $this->url('register')?>">S'inscrire</a>
			</div>
		</div>
	</div>
	
<?php $this->stop('main_content') ?>
