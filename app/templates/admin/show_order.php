<?php $this->layout('admin_layout', ['title' => 'Page réservée !']) ?>

<?php $this->start('main_content') ?>

	<h1>Bienvenue à toi, Ô précieux administrateur</h1>
	<h2>Commande de : <?= $this->e($username) ?></h2>

	<?php


		if (!empty($deliveryplace)) {
			echo '<p>Lieu de livraison : '. $this->e($deliveryplace['name']). '</p>' . '<br> <p> Adresse : ' . $this->e($deliveryplace['address']).'</p>' ;
			echo '<a href="'.$this->url('send_order_confirmation',['cartId' => $cartId]).'">Confirmer la commande</a>';
		}
		else {
			echo '<p>La commande est terminée </p>';
		}
	?>
			
	
	<table>
		<thead>
			<tr>
				<th>
					Titre
				</th>
				<th>
					Couverture
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($books as $book): ?>
				
			<tr>
				<td>
					<?= $this->e($book['title']) ?>
				</td>
				<td>
					<img src="<?php echo $this->assetUrl('img/mini-covers/'.$this->e($book['cover']));?>">
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>

	</table>
		
	
	
<?php $this->stop('main_content') ?>
