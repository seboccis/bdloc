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
				<optgroup label="<?= $this->e($arr) ?>">
<?php
					foreach ($deliveryPlaces as $deliveryPlace) {
						if ($deliveryPlace['code'] == $code) {
?>
							<option value="<?= $this->e($deliveryPlace['id']) ?>"><?= $this->e($deliveryPlace['name']) ?></option>
<?php
						}
					}
?>
				</optgroup>
<?php
			}
?>
			</select>
			<input type="hidden" name="cartIdToOrder" value="<?= $this->e($cartIdToOrder) ?>">
<?php
		}
?>
			<button>Poursuivre</button>
</form>

<div id="showMap">
	<div id="mapDeliveryPlacesChoice"  data-showMap="<?= $this->e($showMap) ?>" data-ajax-deliveryPlace-getMap-path="<?php echo $this->url('ajax_deliveryPlace_getMap'); ?>" data-ajax-deliveryPlace-getDeliveryPlace-path="<?php echo $this->url('ajax_deliveryPlace_getDeliveryPlace'); ?>"></div>
</div>

<p class="legendShowMap">En survolant un marqueur rouge du plan, vous découvrez le nom et l'adresse d'un point-relais.</p>
<p class="legendShowMap"> Veuillez cliquer sur un de ces marqueurs pour le sélectionner.</p>

<div id="choicedDeliveryPlace"></div>

<form action="<?= $this->url('confirm_order'); ?>" method="POST">

	<input type="hidden" name="cartIdToOrder" value="<?= $this->e($cartIdToOrder) ?>">
	<input type="hidden" id="inputChoicedDeliveryPlace" name="deliveryplace" value="">
	<button id="validateChoicedDeliveryPlace">Valider votre point-relais</button>

</form>

<noscript>
	<p>Attention : </p>
	<p>Afin de pouvoir utiliser Google Maps, JavaScript doit être activé.</p>
	<p>Or, il semble que JavaScript est désactivé ou qu'il ne soit pas supporté par votre navigateur.</p>
	<p>Pour afficher Google Maps, activez JavaScript en modifiant les options de votre navigateur, puis essayez à nouveau.</p>
</noscript>

<?php $this->stop('main_content') ?>