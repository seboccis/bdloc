<?php $this->layout('main_layout', ['title' => 'Choix du point-relais']) ?>

<?php $this->start('main_content') ?>

<h2>Ceci est la page de la commande.</h2>

<?php echo $orderError . '<br />' . $orderSuccess?>

	<div id="showMap">
		<div id="mapDeliveryPlacesChoice" data-ajax-deliveryPlace-getMap-path="<?php echo $this->url('ajax_deliveryPlace_getMap'); ?>" data-ajax-deliveryPlace-getDeliveryPlace-path="<?php echo $this->url('ajax_deliveryPlace_getDeliveryPlace'); ?>"></div>
	</div>
	
	<div id="choicedDeliveryPlace"></div>

	<form action="<?= $this->url('confirm_order'); ?>" method="POST">

		<input type="hidden" name="cartIdToOrder" value="<?= $cartIdToOrder; ?>">
		<input type="hidden" id="inputChoicedDeliveryPlace" name="deliveryplace" value="">
		<button id="validateChoicedDeliveryPlace">Valider votre point-relais</button>

	</form>

	<noscript>
		<p>Attention : </p>
		<p>Afin de pouvoir utiliser Google Maps, JavaScript doit être activé.</p>
		<p>Or, il semble que JavaScript est désactivé ou qu'il ne soit pas supporté par votre navigateur.</p>
		<p>Pour afficher Google Maps, activez JavaScript en modifiant les options de votre navigateur, puis essayez à nouveau.</p>
	</noscript>
	<script type="text/javascript" src="<?= $this->assetUrl('js/deliveryPlace.js'); ?>"></script>
	<script type="text/javascript" src="<?= $this->assetUrl('js/markerIconsLibrary.js'); ?>"></script>
	
<?php $this->stop('main_content') ?>