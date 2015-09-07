<?php $this->layout('main_layout', ['title' => 'Historique des commandes']) ?>

<?php $this->start('main_content') ?>


	<h2>Ceci est la page d'historique des commandes.</h2>

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
		<?php foreach ($cartToBooks as $cartToBook) :?>
		
		<h1>Commande du <?= $cartToBook['cartBeginDate']?> au <?= $cartToBook['cartEndDate']?></h1>
		<table>
			<thead>
				Titre
			</thead>
			<?php 
			
			foreach ($cartToBook['books'] as $book) : ?>
			<tbody>
				<tr>
					<td>
						<?=$book['title']?>
					</td>
				</tr>
						
			</tbody>
		

		<?php endforeach ?>
		</table>
		
		<?php endforeach ?>
	</div>
	
<?php $this->stop('main_content') ?>