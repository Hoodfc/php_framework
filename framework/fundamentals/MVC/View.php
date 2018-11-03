<?php 
namespace Framework\Fundamentals\MVC;

abstract class View {

	private function wUrl($uri)
	{
		return \Framework\Components\Wurler\Wurler::asset($uri);	
	}

	public static function out($arg)
	{
		extract($arg);
		require_once (self::wUrl('chuck.php'));
	}
    
}


?>