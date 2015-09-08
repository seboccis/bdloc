<?php $this->layout('main_layout', ['title' => 'Validation de la commande']) ?>

<?php $this->start('main_content') ?>



	<h2>Détail de la commande</h2>
<table>
	
	<thead>
		<tr>
			<th>
				Titre
			</th>
		</tr>
	</thead>
<?php foreach ($books as $book): ?>
	<tbody>
		<tr>
			<td>
				<?= $book['title']?></p>
			</td>
		</tr>
	</tbody>
	

<?php endforeach ?>
</table>
	<p>Nom et adresse du point de livraison : <?= $deliveryPlace['name'] . ", " . $deliveryPlace['address']?></p>

	<a href="<?=$this->url('save_order',['cartIdToOrder' => $cartIdToOrder, 'deliveryPlace' => $deliveryPlace['id']])?>">Valider la commande</a>
	
<?php $this->stop('main_content') ?>