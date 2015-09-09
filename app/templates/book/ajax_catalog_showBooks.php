<?php 									?>
	<input type="hidden" id='dataRequest' data-request-precStart="<?= $precStart; ?>" data-request-first="<?= $first; ?>" data-request-last="<?= $last; ?>" data-request-total="<?= $total; ?>" data-request-nextStart="<?= $nextStart; ?>">
<?php foreach($books as $book){			?>
	
	<div class="card<?php if($book['quantity_available'] == 0){ echo ' card-bookNotAvailable';} ?> table" data-bookId="<?= $book['id'] ?>">

		<div class="row">

			<div class="cell">

				<img src="<?php echo $this->assetUrl('img/mini-covers/'.$book['cover']);?>">

			</div>
			<div class="cell cell-text">

				<h1><?php echo $this->e($book['title'])?></h1>
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
				<p<?php if($book['quantity_available'] == 0){ echo ' class="pNotAvailable"';} ?>><?php echo $this->e($book['string_quantity_available'])?></p>
				<button class="detail btn btn-long btn-info" data-book-id="<?= $book['id']; ?>"><i class="fa fa-plus-circle"></i> Plus de détails</button>
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
