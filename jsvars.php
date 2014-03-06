<?php

/**
 * Plugin_Jsvars
 */
class Plugin_Jsvars extends Plugin
{
	/**
	 * dumps the attributes on the plugin as [namespaced] js vars
	 * @return string
	 */
	public function dump() {

		// reserve some attributes that wo don't want as js vars
		$reserved = array(
			'namespace'
		);

		// define "magic" keys which hold internal values
		$specials = array(
			'theme_path' => $this->template->get_theme_path(),
			'theme_url' => site_url($this->template->get_theme_path()),
		);

		// define our formats
		$html = array(
			'wrap' => "<script>%s</script>",
			'keyValuePair' => 'var %s = \'%s\';',
			'namespacedkeyValuePair' => '%s: \'%s\'',
			'namespace' => 'var %s = {%s}',
		);

		$attributes = $this->attributes();
		$vars = array();

		foreach (array_merge($attributes, $specials) as $name => $value) {
			// skip the reserved vars
			if(in_array($name, $reserved)) continue;

			$name = $this->_snakeToCamel($name);

			if($this->attribute('namespace')) {
				// if we want to namespace, use the namespaced format
				$vars[] = sprintf($html['namespacedkeyValuePair'], $name, $value);
			} else {
				// otherwise, just generate plain old key value pair vars
				$vars[] = sprintf($html['keyValuePair'], $name, $value);
			}

		}

		if(count($vars) === 0) return;

		if($this->attribute('namespace')) {
			// return the namespaced object
			return sprintf(
						$html['wrap'],
						sprintf(
							$html['namespace'],
							$this->attribute('namespace'),
							implode(",\n", $vars)
						)
					);
		} else {
			// or just return concatenated vars
			return sprintf(
						$html['wrap'],
						implode('', $vars)
					);
		}

	}

	private function _snakeToCamel($val) {
		$val = str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
		$val = strtolower(substr($val,0,1)).substr($val,1);
		return $val;
	}

}