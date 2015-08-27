<?php $this->layout('main_layout', ['title' => 'Panier']) ?>

<?php $this->start('main_content') ?>

<h2>Ceci est la page du panier.</h2>

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
		</tr>
	<?php endforeach ?>
	</tbody>

</table>


<?php $this->stop('main_content') ?>