<?php $this->layout('catalog_layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>

	<div id="sideBar" data-ajax-catalog-getBooks-path="<?= $this->url('ajax_catalog_getBooks');?>">
		
		<div class="borderedWithTitle">

			<h2>Filtres</h2>

			<form action="" method='POST' id="formSideBarFilters">

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
					<input type="text" id="keyword" data="<?php echo $this->url('ajax_catalog_keyword'); ?>" value="">
					<button>Rechercher</button>				
					<div id="result"></div>
				</div>

			</form>

		</div>

	</div>

	<div id="content">

		<div id="resultsBar">

			<div class="borderedWithTitle">

				<h2>Résultats</h2>

				<form action="" method='POST' id="formResultsBarFilters" class="elementOfResultsBar">

					<div>
						<select name="number">
						  <option value="10">Afficher 10 résultats</option> 
						  <option value="20" selected>Afficher 20 résultats</option>
						  <option value="40">Afficher 40 résultats</option>
						</select>
					</div>

					<button id="btnNumber">Valider</button>

				</form>

				<div id="paginationNav" class="elementOfResultsBar">
					<a href="" id="prevBooks">&lsaquo; Précédentes</a>
					<span id="pagination">#<span id="first">1</span>à#<span id="last">20</span>sur<span id="total"></span>BD</span>
					<a href="" id="nextBooks">Suivantes &rsaquo;</a>
				</div>

			</div>
			
		</div>

		<div id="showBooks"></div>

	</div>
	
<?php $this->stop('main_content') ?>