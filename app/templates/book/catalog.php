<?php $this->layout('catalog_layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>
	<div id="sideBar">

		<form action="" method='POST' id="formChooseGenres">

		<?php foreach($genres as $genre){	?>
			<label for="checkbox<?= $genre['id']?>"><input type="checkbox" name="genres[]" id="checkbox<?= $genre['id']?>" value="<?= $genre['id']; ?>"><?= $genre['genre'];?></label>
		<?php }								?>

			<button id="buttonChooseGenres">Valider</button>

		</form>
	</div>

	<div id="showBooks"></div>
	
<?php $this->stop('main_content') ?>