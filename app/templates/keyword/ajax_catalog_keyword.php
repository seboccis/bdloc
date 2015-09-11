<?php foreach ($keywordEnds as $keywordEnd){	?>
		
	<a href="#" data-keyword="<?= $this->e($keywordBeginning) . $this->e($keywordEnd) ?>"><span><?= $this->e($keywordBeginning) ?></span><em><?= $this->e($keywordEnd) ?></em></a>
				
<?php }											?>