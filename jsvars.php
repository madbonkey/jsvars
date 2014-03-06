<?php

/**
* JSVars
*/
class Plugin_Jsvars extends Plugin
{

	public function dump() {

		// reserve some attributes that wo don't want as js vars
		$reserved = array('namespace', 'theme_path');

		foreach ($this->attributes() as $name => $value) {

			// skip the reserved vars
			if(in_array($name, $reserved)) continue;

		}



	}

}