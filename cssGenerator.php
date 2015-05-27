<?php

define("CSSGEN_PROPPATH", "css/properties_generated.css");
define("CSSGEN_DEPSPOINTERSTR", "/*1CSSGEN_DEPS_POINTER1*/");

class CSSGEN
{
	// Generates CSS for the property, puts in the class, saves the property
	public static function addProperty(&$property, $css, $cssdeps = "")
	{
		/*if (!file_exists(CSSGEN_PROPPATH))
		{
			$f = fopen(CSSGEN_PROPPATH, "w");
			fwrite($f, CSSGEN_DEPSPOINTERSTR);
			fclose($f);
		}*/
		$f = fopen(CSSGEN_PROPPATH, "w+");
		$arr = explode(CSSGEN_DEPSPOINTERSTR, fread($f, filesize(CSSGEN_PROPPATH)));

		$class = ".property-" . $property->json["property"]["id"];
		$property->json["property"]["cssclass"] = $class;
		$arr[0] .= $class . "{" . $css . "}";

		$property->save();

		if (!empty($cssdeps))
		{
			$arr[1] .= $cssdeps;
		}
		if (empty($arr[1]))
		{
			$arr[1] = "";
		}

		fwrite($f, $arr[0] . CSSGEN_DEPSPOINTERSTR . $arr[1]);
		fclose($f);
	}
}

?>