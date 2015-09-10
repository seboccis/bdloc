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
			<?php foreach ($allOrdersAndUsers as $allOrderAndUser){
					if ($allOrderAndUser['status'] != 0) { ?>
						
				<tr>
					<td>
						<?php echo $allOrderAndUser['username']; ?>
						
					</td>
					<td>
						<?php switch ($allOrderAndUser['status']) {
								case '1':
									echo "A traiter";
									break;
								case '2':
									echo "Commande en cours";
									break;
								case '3':
									echo "Commande terminée";
								
								break;
							} ?>
					</td>
					<td>
						<?= $allOrderAndUser['begin_date']?>
					</td>
					<td>
						<a href="<?=$this->url('show_order',['cartId' => $allOrderAndUser['cartId'], 'status' => $allOrderAndUser['status'], 'username' => $allOrderAndUser['username']])?>"><i class="fa fa-search"></i></a>
					</td>
					
				</tr>
						
			<?php }}?>
		</tbody>
	</table>

		
	</div>
	
	
<?php $this->stop('main_content') ?>
