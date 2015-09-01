<?php $this->layout('main_layout', ['title' => 'Validation de la commande']) ?>

<?php $this->start('main_content') ?>



	<h2>Détail de la commande</h2>

<?php foreach ($books as $book): ?>
	<p>Titre : <?= $book['title']?></p>

<?php endforeach ?>
	<p>Nom et adresse du point de livraison : <?= $deliveryPlace['name'] . ", " . $deliveryPlace['address']?></p>

	<a href="<?=$this->url('save_order',['cartIdToOrder' => $cartIdToOrder, 'deliveryPlace' => $deliveryPlace['id']])?>">Valider la commande</a>
	
<?php $this->stop('main_content') ?>