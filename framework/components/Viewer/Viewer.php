<?php 
namespace Framework\Components\Viewer;

class Viewer implements ViewerInterface {
	
	protected $viewPath;
	protected $viewOptions;
	protected $viewIterator;
	protected $cachedViewFile;


	public function __construct(string $viewName, array $options = null,string $dir = null)
	{
		$this->viewPath = ($dir !== null) 
			? (ROOT . $dir . DIRECTORY_SEPARATOR . $viewName)
			: (VIEW_PATH . $viewName)
			;

		$this->viewOptions = $options;
		$this->viewIterator = new ViewerIterator($this->viewPath);

		$cachePath = ViewerUtils::setCachedFile($viewName); 
		$this->cachedViewFile = fopen($cachePath, 'w');
	}

	public function serialize(){
		
		for($serializeIt = $this->viewIterator; $serializeIt->valid(); $serializeIt->next()){
			$currentLine = $serializeIt->current();
			
			if(ViewerUtils::contains(ViewerUtils::startLimiter(), $currentLine)){
				$viewString = ViewerUtils::takeViewString($currentLine);
			}
			else fwrite($this->cachedViewFile, $currentLine);
		}
	}

	public function view()
	{
		return true;
	}

}

?>