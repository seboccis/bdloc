<?php $this->layout('layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>
	<h2>Ceci est le catalogue.</h2>

	<div class="showCovers">
		
	<?php foreach($books as $book){	?>
	<div class="cover">
		<img src="<?php echo $this->assetUrl('img/covers/'.$book['cover']);?>">
		<h1><?php echo $this->e($book['title'])?></h1>
		<p>Auteurs : <?php echo $this->e($book['scenaristFirstName'])." ". $this->e($book['scenaristLastName']) . " et " . $this->e($book['illustratorFirstName']) . " " . $this->e($book['illustratorLastName'])?></p>
	</div>
	<?php }							?>
	</div>
	
<?php $this->stop('main_content') ?>
