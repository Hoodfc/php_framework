<?php 
	//require_once('./core/Fundamentals/Kernel.php');
	//\Core\Fundamentals\Kernel\Kernel::call($_SERVER['REQUEST_URI']);

	require_once('./framework/Loader.php');     
	spl_autoload_register( '\Core\Loader::baseLoader');
	
	// Framework\Core\Dispatcher::dispatch(new Framework\Core\Request(rtrim(strtolower($_SERVER['REQUEST_URI']), '/')));	
	// new Framework\Core\Kernel(strtolower($_SERVER['REQUEST_URI']));

	$viewer = new Framework\Components\Viewer\Viewer('index.view.php');

	$viewer->serialize();


?>