<?php $this->layout('catalog_layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>
	<div class="sideBar" data="<?= $this->url('ajax_catalog_getBooks');?>">
		<h2>Filtres</h2>

		<form action="" method='POST' id="formChooseGenres">

			<div>
				<h3>Catégories</h3>
				<?php foreach($genres as $genre){	?>
					<label for="checkbox<?= $genre['id']?>"><input type="checkbox" name="genres[]" class="checkbox" id="checkbox<?= $genre['id']?>" value="<?= $genre['id']; ?>"><?= $genre['genre'];?></label>
				<?php }								?>
			</div>

			<div>
				<h3>Disponibilité</h3>
				<label for="checkboxAvailability"><input type="checkbox" name="availability" class="checkbox" id="checkboxAvailability" value="1">Disponibles</label>
			</div>

			<div>
				<h3>Recherche</h3>
			</div>

		</form>
	</div>

	<div id="showBooks"></div>
	<div id="showDetail" data="<?php echo $this->url('ajax_catalog_detail'); ?>"></div>
	
<?php $this->stop('main_content') ?>