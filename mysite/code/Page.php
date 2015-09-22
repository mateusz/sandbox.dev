<?php
class Page extends SiteTree {

	public function EnvDetails() {
		$list = new ArrayList();
		foreach(array(
			'Hostname' => $_SERVER['HTTP_HOST'],
			'PHP' => phpversion(),
			'PHP extensions' => implode(', ', get_loaded_extensions()),
			'OS' => php_uname()
		) as $k => $v) {
			$list->push(new ArrayData(array(
				'Name' => $k,
				'Value' => $v
			)));
		}
		return $list;
	}

}

class Page_Controller extends ContentController {

	public function getTestDefines() {
		$defs = array();
		foreach (get_defined_constants() as $k => $v) {
			if (strpos($k, 'TEST_')===0) {
				$defs[] = [
					'Key' => $k,
					'Value' => $v
				];
			}
		}
		return new ArrayList($defs);
	}

	public function init() {
		parent::init();
		Requirements::themedCSS('reset');
		Requirements::themedCSS('layout');
		Requirements::themedCSS('typography');
		Requirements::themedCSS('form');
	}
}
