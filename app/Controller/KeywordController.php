<?php

namespace Controller;

use \Manager\KeywordManager;
use \Manager\BookKeywordManager;

class KeywordController extends DefaultController
{

	public function ajaxCatalogKeyword()
	{
		$keywordManager = new KeywordManager;
		
		$keywordBeginning = $_GET['keywordBeginning'];
		
		$arrayKeywords = $keywordManager->findKeywords($keywordBeginning);

		$keywords = [];

		foreach($arrayKeywords as $arrayKeyword){
			$keywords[] = $arrayKeyword['keyword'];
		}

		$keywordEnds = [];

		$start = strlen($keywordBeginning);

		foreach($keywords as $keyword){
			$keywordEnd = substr($keyword, $start);
			$keywordEnds[] = $keywordEnd;
		}

		$data = array(
					'keywordBeginning'	=> $keywordBeginning,
					'keywordEnds' 		=> $keywordEnds,
				);

		$this->show('keyword/ajax_catalog_keyword', $data);
	}

}