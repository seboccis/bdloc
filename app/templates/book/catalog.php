<?php $this->layout('layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>
	<h2>Ceci est le catalogue.</h2>

	<div class="showCovers">
	<?php foreach($books as $book){	?>
	<div class="cover">
		<img src="<?php echo $this->assetUrl('img/covers/'.$book['cover']);?>">
	</div>
	<?php }							?>
	</div>
	
<?php $this->stop('main_content') ?>
