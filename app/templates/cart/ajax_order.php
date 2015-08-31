<h2>Ceci est la page de la commande.</h2>

<?php echo $orderError . '<br />' . $orderSuccess?>

<?php foreach ($books as $book) :?>

	<p><?= $this->e($book['title'])?></p>

<?php endforeach ?>

<form action="">
	<legend>Choisissez le point de livraison</legend>
	<select name="deliveryplaces" id="deliveryplaces">
		<option value="deliveryplaces">Paris</option>
		<option value="deliveryplaces">Lyon</option>
		<option value="deliveryplaces">Marseille</option>
	</select>

	<input type="submit" value="Poursuivre">
</form>
