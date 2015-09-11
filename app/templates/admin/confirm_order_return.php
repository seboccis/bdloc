<?php $this->layout('admin_layout', ['title' => 'Page réservée !']) ?>

<?php $this->start('main_content') ?>

	<h1>Bienvenue à toi, Ô précieux administrateur</h1>
	<?php if (empty($books)) { ?>
					<form action="" method="POST">
						<label for="cartId">Veuillez indiquer le numéro de la commande</label>
						<input id="cartId" name="cartId" type="text">
						<button>Valider</button>
					</form>
	<?php } 
	 else 	{ ?>
						<table>
							<thead>
								<tr>
									<th>
										Titre
									</th>
									<th>
										Couverture
									</th>
									<th>
										Valider le retour
									</th>
								</tr>
							</thead>
							<tbody>
								<form action="<?= $this->url('validate_return')?>" method="POST">
									<?php foreach ($books as $book): ?>	
											<tr>
												<td>
													<?= $this->e($book['title']) ?>
												</td>
												<td>
													<img src="<?= $this->assetUrl('img/mini-covers/'.$book['cover']);?>">
												</td>
												<td>
													<input type="checkbox" name="<?= $this->e($book['title']) ?>" value="<?= $this->e($book['id']) ?>">
												</td>
											</tr>
									<?php endforeach ?>
									<button>Valider</button>
								</form>
							</tbody>

						</table>
							
	<?php } ?>
	
	
<?php $this->stop('main_content') ?>
	
	
