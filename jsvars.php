<?php

/**
* JSVars
*/
class Plugin_Jsvars extends Plugin
{

	public function dump() {

		// reserve some attributes that wo don't want as js vars
		$reserved = array('namespace', 'theme_path');

		// define our formats
		$html = array(
			'wrap' => "<script>%s</script>",
			'keyValuePair' => 'var %s = \'%s\';',
			'namespacedkeyValuePair' => '%s: \'%s\'',
			'namespace' => 'var %s = {%s}',
		);

		$vars = array();

		foreach ($this->attributes() as $name => $value) {
			// skip the reserved vars
			if(in_array($name, $reserved)) continue;

			if($this->attribute('namespace')) {
				// if we want to namespace, use the namespaced format
				$vars[] = sprintf($html['namespacedkeyValuePair'], $name, $value);
			} else {
				// otherwise, just generate plain old key value pair vars
				$vars[] = sprintf($html['keyValuePair'], $name, $value);
			}

		}

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

}