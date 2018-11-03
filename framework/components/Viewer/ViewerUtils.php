<?php 
namespace Framework\Components\Viewer;

/**
 * summary
 */
class ViewerUtils 
{
	public static function startLimiter(){
		return '{{';
	}

	public static function endLimiter(){
		return '}}';
	}

	public static function setCachedFile($viewName){

		$filename = pathinfo($viewName)['filename'];
		return CACHE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . basename($filename) . '-' . substr((md5($viewName)) , 0, 7) . '.php';	
	}

	public static function takeViewString($currentLine){
		$iniPos = strpos($currentLine, self::startLimiter())+2;
		$endPos = strpos($currentLine, self::endLimiter())-2;
		return trim(substr($currentLine, $iniPos, $endPos));
	}

	public static function contains($needle, $haystack)
	{
		return strpos($haystack, $needle) !== false;
	}
}
?>