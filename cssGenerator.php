<?php

class PropertyCSSGenerator
{
	var $n = 0;
	var $output = "";
	var $additional = "";

	public function add($property)
	{
		if (isset($property["css"]))
		{
			$output += ".property-" . (string)($n++) . "-" . $property["name"] . "{" . $property["css"] . "}";
			
			if (isset($property["cssadditional"]))
			{
				$additional += $property["cssadditional"];
			}
		}
	}

	public function applyToPage()
	{
		$css = $output . $additional;

		// TODO: Find a way to do this

	}
}

?>