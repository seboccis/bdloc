<?php $this->layout('admin_layout', ['title' => 'Page réservée !']) ?>

<?php $this->start('main_content') ?>

	<h1>Bienvenue à toi, Ô précieux administrateur</h1>

	<div class="container">
		
	<table>
		<thead>
			<tr>
				<th>
					Pseudo de l'utilisateur
				</th>
				<th>
					Status de la commande
				</th>
				<th>
					Date de la commande
				</th>
				<th>
					Actions
				</th>
				
			</tr>
		</thead>

		<tbody>
			<?php foreach ($allOrdersAndUsers as $allOrderAndUser): ?>
						
				<tr>
					<td>
						<?php 
						if ($allOrderAndUser['status'] != 0) {
							echo $allOrderAndUser['username'];
						}?>
						
					</td>
					<td>
						<?php
						if ($allOrderAndUser['status'] != 0) {
							
							switch ($allOrderAndUser['status']) {
								case '1':
									echo "A traiter";
									break;
								case '2':
									echo "Commande terminée";
								
								break;
							}
						}
						?>
					</td>
					<td>
						<?php if ($allOrderAndUser['status'] != 0): ?>
							
						<?= $allOrderAndUser['begin_date']?>
						<?php endif ?>
					</td>
					<td>
						<?php if ($allOrderAndUser['status'] != 0): ?>
						<a href="<?=$this->url('show_order',['cartId' => $allOrderAndUser['cartId'], 'status' => $allOrderAndUser['status'], 'username' => $allOrderAndUser['username']])?>"><i class="fa fa-search"></i></a>
						<?php endif ?>
					</td>
					
				</tr>
						
			<?php endforeach ?>
		</tbody>
	</table>

		
	</div>
	
	
<?php $this->stop('main_content') ?>
