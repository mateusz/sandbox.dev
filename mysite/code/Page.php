<?php
class Page extends SiteTree {

	private static $db = array(
		"Testing" => "Varchar(255)"
	);

	public function EnvDetails() {

		$phpExtensionList = new ArrayList();
		$extensions = get_loaded_extensions();
		natcasesort($extensions);
		foreach($extensions as $extension) {
			$version = phpversion($extension);
			if(!$version && $extension == 'gd') {
				$info = function_exists('gd_info') ? gd_info() : array();
				$version = isset($info['GD Version']) ? $info['GD Version'] : '';
			}
			if(!$version && $extension == 'pcre') {
				$version = PCRE_VERSION;
			}
			if(!$version && $extension == 'curl') {
				$version = curl_version()['version'];
			}
			if(!$version && $extension == 'openssl') {
				$version = OPENSSL_VERSION_TEXT;
			}
			if(!$version && $extension == 'libxml') {
				$version = LIBXML_DOTTED_VERSION;
			}

			// Extension version shows as 0.7-dev, which isn't useful. Use SQLite3::version() instead.
			if($extension == 'sqlite3') {
				$version = SQLite3::version()['versionString'];
			}
			$phpExtensionList->push(new ArrayData([
				'Value' => sprintf('%s - %s', $extension, $version)
			]));
		}

		$list = new ArrayList();
		foreach(array(
			'Hostname' => $_SERVER['HTTP_HOST'],
			'Web server' => $_SERVER['SERVER_SOFTWARE'],
			'PHP' => phpversion(),
			'OS' => php_uname(),
			'PHP extensions' => $phpExtensionList,
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

	public function init() {
		parent::init();
		Requirements::themedCSS('reset');
		Requirements::themedCSS('layout');
		Requirements::themedCSS('typography');
		Requirements::themedCSS('form');
	}
}
