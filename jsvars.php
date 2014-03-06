<?php

/**
* JSVars
*/
class Plugin_Jsvars extends Plugin
{

	public function dump() {

		// reserve some attributes that wo don't want as js vars
		$reserved = array('namespace', 'theme_path');

		$html = array(
			'wrap' => '<script>%s</script>',
			'keyValuePair' => '%s = \'%s\'',
		);

		$vars = array();
		foreach ($this->attributes() as $name => $value) {

			// skip the reserved vars
			if(in_array($name, $reserved)) continue;

			$vars[] = sprintf($html['keyValuePair'], $name, $value);

		}

		return sprintf($html['wrap'], implode(",\n", $vars);

	}

}