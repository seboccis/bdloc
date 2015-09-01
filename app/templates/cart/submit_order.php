<?php $this->layout('main_layout', ['title' => 'Vérification de la commande']) ?>

<?php $this->start('main_content') ?>

<h2>Ceci est la page de la commande.</h2>

<?php echo $orderError . '<br />' . $orderSuccess?>

<form action="<?=$this->url('confirm_order')?>" method="POST">
	<legend>Choisissez le point de livraison</legend>
<?php 
		if (!empty($deliveryPlaces)) {
?>
			<select name="deliveryplace" id="deliveryplace">
<?php
			for ($i=1; $i <= 20 ; $i++) { 
				$arr = $i.($i==1 ? "er arrondissement" : "ème arrondissement");
				$code = $i + 75000;
?>
				<optgroup label="<?= $arr ?>">
<?php
					foreach ($deliveryPlaces as $deliveryPlace) {
						if ($deliveryPlace['code'] == $code) {
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
			<input type="hidden" name="cartIdToOrder" value="<?= $cartIdToOrder ?>">
<?php
		}
?>
			<button>Poursuivre</button>
</form>


<?php $this->stop('main_content') ?>