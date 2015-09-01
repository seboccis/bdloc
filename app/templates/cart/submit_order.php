<?php $this->layout('main_layout', ['title' => 'Panier']) ?>

<?php $this->start('main_content') ?>

<h2>Ceci est la page de la commande.</h2>

<?php echo $orderError . '<br />' . $orderSuccess?>

<?php if (!empty($books)) {
		foreach ($books as $book) :
?>

	<p><?= $this->e($book['title'])?></p>

<?php endforeach ?>
<?php } ?> 
	

<form action="">
	<legend>Choisissez le point de livraison</legend>
<?php 
		if (!empty($deliveryPlaces)) {
?>
			<select name="deliveryplaces" id="deliveryplaces">
<?php
			for ($i=1; $i <= 20 ; $i++) { 
				$arr = 75000 + $i;
?>
				<optgroup label="<?= $arr ?>">
<?php
					foreach ($deliveryPlaces as $deliveryPlace) {
						if ($deliveryPlace['code'] == $arr) {
?>
							<option value="<?=$deliveryPlace['id']?>"><?= $deliveryPlace['name']?></option>
<?php
						}
					}
?>
				</optgroup>
<?php
			}
?>
			</select>
<?php
		}
?>
			
			

	<input type="submit" value="Poursuivre">
</form>


<?php $this->stop('main_content') ?>