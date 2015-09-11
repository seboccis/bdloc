<?php 									?>
	<input type="hidden" id='dataRequest' data-request-precStart="<?= $this->e($precStart) ?>" data-request-first="<?= $this->e($first) ?>" data-request-last="<?= $this->e($last) ?>" data-request-total="<?= $this->e($total) ?>" data-request-nextStart="<?= $this->e($nextStart) ?>">
<?php foreach($books as $book){			?>
	
	<div class="card<?php if($book['quantity_available'] == 0){ echo ' card-bookNotAvailable';} ?> table" data-bookId="<?= $this->e($book['id']) ?>">

		<div class="row">

			<div class="cell">

				<img src="<?php echo $this->assetUrl('img/mini-covers/'.$this->e($book['cover']));?>">

			</div>
			<div class="cell cell-text">

				<h1><?= $this->e($book['title'])?></h1>
				<p>
					Scénariste : 
					<?php 
						if (empty($this->e($book['scenaristAka']))) {
							echo $this->e($book['scenaristFirstName']) . " " . $this->e($book['scenaristLastName']);
						} else {
							echo $this->e($book['scenaristAka']);
						}
					?>		
				</p>
				<p>
					Illustrateur : 
					<?php
						if (empty($this->e($book['illustratorAka']))) {
							echo $this->e($book['illustratorFirstName']) . " " . $this->e($book['illustratorLastName']) ;
						} else {
							echo $this->e($book['illustratorAka']);
						}
					?>
				</p>
				<p>
					Coloriste : 
					<?php
						if (empty($this->e($book['coloristAka']))) {
							echo $this->e($book['coloristFirstName']) . " " . $this->e($book['coloristLastName']) ;
						} else {
							echo $this->e($book['coloristAka']);
						}
					?>
				</p>
				<p<?php if($book['quantity_available'] == 0){ echo ' class="pNotAvailable"';} ?>><?= $this->e($book['string_quantity_available']) ?></p>
				<button class="detail btn btn-long btn-info" data-book-id="<?= $this->e($book['id']) ?>"><i class="fa fa-plus-circle"></i> Plus de détails</button>
				<?php if ($book['isBookInCart'] == 0 && $book['quantity_available'] != 0){	?>
					<button class="addToCart btn btn-success btn-long"><i class="fa fa-cart-plus"></i> Ajouter au panier</button>
				<?php }else if ($book['isBookInCart'] == 1){								?>
					<p id="msgInCart">Ajouté au panier !</p>
				<?php }																		?>
				<p id="cartError"></p>
			</div>

		</div>

	</div>	

<?php }								?>

<?php if(empty($books)){			?>

	<span>Il n'existe pas de BD correspondant à votre recherche.</span>

<?php }								?>
