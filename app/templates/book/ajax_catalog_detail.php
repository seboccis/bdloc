<?php ?>

	<figure>
		
	<img src="<?php echo $this->assetUrl('img/covers/'.$book['cover']);?>">
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
			<a href="<?= $this->url('add_to_cart',['bookId'=>$book['id']])?>">Ajouter au panier</a>
	</figcaption>
	</figure>