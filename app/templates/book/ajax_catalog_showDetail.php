<?php ?>

	<figure data-bookId="<?= $book['id'] ?>">
		
		<img src="<?php echo $this->assetUrl('img/covers/'.$book['cover']);?>">

		<button id='closeLightBox'><span>&times;</span></button>

		<figcaption>
			
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
				<?php if ($book['isBookInCart'] == 0 && $book['quantity_available'] != 0){	 ?>
					<button class="addToCart">Ajouter au panier</a>
				<?php }else if($book['isBookInCart'] == 1){									 ?>
					<p>Déjà dans le panier !</p>
				<?php }																		 ?>
				<p id="cartError"></p>
		</figcaption>

	</figure>
	