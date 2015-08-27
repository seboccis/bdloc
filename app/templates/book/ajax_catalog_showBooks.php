<?php ?>
	<input type="hidden" id='dataRequest' data-request-precStart="<?= $precStart; ?>" data-request-first="<?= $first; ?>" data-request-last="<?= $last; ?>" data-request-total="<?= $total; ?>" data-request-nextStart="<?= $nextStart; ?>">
		
<?php foreach($books as $book){		?>
	
	<a href="" class="detail" value="<?php echo $book['id']; ?>">

		<div class="cover table">

			<div class="row">

				<div class="cell">

					<img src="<?php echo $this->assetUrl('img/mini-covers/'.$book['cover']);?>">

				</div>
				<div class="cell">

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
			
				</div>

			</div>

		</div>

	</a>

<?php }								?>

<?php if(empty($books)){			?>

	<span>Il n'existe pas de BD correspondant à votre recherche.</span>

<?php }								?>
