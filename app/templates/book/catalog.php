<?php $this->layout('main_layout', ['title' => 'Catalogue']) ?>

<?php $this->start('main_content') ?>

	<div id="sideBar">

		<form action="" method='POST' id="formSideBarFilters" class='fieldset'>

			<fieldset>

				<legend>Filtres</legend>

				<div class='filter'>
					<h3>Catégories</h3>

					<div class="filters">	
						<?php foreach($genres as $genre){	?>
							<label for="checkbox<?= $this->e($genre['id']) ?>"><input type="checkbox" name="genres[]" class="checkbox" id="checkbox<?= $this->e($genre['id']) ?>" value="<?= $this->e($genre['id']) ?>"><?= $this->e($genre['genre']) ?></label>
						<?php }								?>
					</div>

				</div>

				<div  class='filter'>
					<h3>Disponibilité</h3>

					<div class="filters">
						<label for="checkboxAvailability"><input type="checkbox" name="availability" class="checkbox" id="checkboxAvailability" value="1">Disponibles</label>
					</div>

				</div>

				<div  class='filter'>
					<h3>Recherche</h3>

					<div class="filters">
						<input type="text" id="inputKeyword" name="keyword" placeholder="mot-clé" data-ajax-catalog-getKeywords-path="<?php echo $this->url('ajax_catalog_keyword'); ?>" value="" autocomplete="off">
						<button id="btnRefresh">Rafraîchir</button>				
						<div id="resultKeywordResearch"></div>
					</div>

				</div>

			</fieldset>

		</form>

	</div>

	<div id="content">

		<div id="resultsBar">

			<form action="" method='POST' id="formResultsBarFilters" class="fieldset">
				
				<fieldset>
					
					<legend>Résultats</legend>

					<div class="elementOfResultsBar">
						<select name="sort" id="selectCatalogSort">
						  <option value="" selected>Trier par</option> 
						  <option value="serie">Trier par série</option>
						  <option value="title">Trier par titre</option>
						</select>
					</div>

					<div class="elementOfResultsBar">
						<select name="number" id="selectCatalogNumber">
						  <option value="20" selected>Afficher 20 résultats</option>
						  <option value="40">Afficher 40 résultats</option>
						  <option value="60">Afficher 60 résultats</option>
						</select>
					</div>

					<div id="paginationNav" class="elementOfResultsBar">
						<a href="" id="prevBooks">&lsaquo; Précédentes</a>
						<span id="pagination">#<span id="first">1</span>à#<span id="last">20</span>sur<span id="total"></span>BD</span>
						<a href="" id="nextBooks">Suivantes &rsaquo;</a>
					</div>

				</fieldset>

			</form>
			
		</div>

		<div id="showBooks" data-ajax-catalog-addToCart-path="<?= $this->url('ajax_catalog_add_to_cart')?>" data-ajax-catalog-getBooks-path="<?= $this->url('ajax_catalog_getBooks');?>"></div>

	</div>
	
<?php $this->stop('main_content') ?>