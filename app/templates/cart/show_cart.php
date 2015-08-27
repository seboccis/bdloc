<?php $this->layout('main_layout', ['title' => 'Panier']) ?>

<?php $this->start('main_content') ?>

<h2>Ceci est la page du panier.</h2>

<?php if (!empty($books)) { ?>
	
<table>
	<thead>
		<th>Titre</th>
		<th>Cover</th>
	</thead>
	<tbody>
<?php foreach ($books as $book) :?>
		<tr>
			<td>
				<?= $this->e($book['title'])?>
			</td>
			<td>
				<img src="<?php echo $this->assetUrl('img/mini-covers/'.$book['cover']);?>">
			</td>
			<td>
				<a href="<?= $this->url('remove_book_from_cart',['bookId'=>$book['id']])?>">Retirer du panier</a>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>

</table>

<?php }
	else{
		echo '<span>'. $cartEmpty .'</span>' ;
	} ?>

<?php $this->stop('main_content') ?>