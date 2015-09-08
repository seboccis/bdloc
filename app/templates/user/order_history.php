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
		<?= $orderEmpty ?>
		
		<h2>Commandes terminées</h2>
		<table>
			<thead>
				<tr>
					<th>Titre</th>
					<th>Date de location</th>
					<th>Date de retour</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($cartToBooks as $cartToBook) :?>
			<?php 
			
			foreach ($cartToBook['books'] as $book) : ?>
				<tr>
					<td>
						<?=$book['title']?>
					</td>
					<td>
						<?= $cartToBook['cartBeginDate']?>
					</td>
					<td>
						<?= $cartToBook['cartEndDate']?>
					</td>
				</tr>
						
		

		<?php endforeach ?>
			</tbody>
		<?php endforeach ?>
		</table>
		
		
		<?= $orderInRentEmpty ?>
		
		<h2>Commandes en cours</h2>
		<table>
			<thead>
				<tr>
					<th>Titre</th>
					<th>Date de location</th>
					<th>Date de retour</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($cartToBooksInRent as $cartToBookInRent) :?>
			<?php 
			
			foreach ($cartToBookInRent['booksInRent'] as $book) : ?>
				<tr>
					<td>
						<?=$book['title']?>
					</td>
					<td>
						<?= $cartToBookInRent['cartInRentBeginDate']?>
					</td>
					<td>
						<em>En cours de location</em>
					</td>
				</tr>
						
		

		<?php endforeach ?>
		<?php endforeach ?>
			</tbody>
		</table>
		
	</div>
	
<?php $this->stop('main_content') ?>