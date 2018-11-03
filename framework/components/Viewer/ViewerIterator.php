<?php 
namespace Framework\Components\Viewer;

class ViewerIterator implements \Iterator
{
	private $viewFile;
	private $viewPath;
	private $line;
	private $position;
	private $ended;

	public function __construct($filename)
	{
		$this->viewPath = $filename;
		$this->viewFile = fopen($filename, 'r');
		$this->line = null;
		$this->ended = false;
		$this->position = 0;
	}	

	public function getFile(){return $this->viewFile;}

	public function rewind()
	{
		self::closeView();
		$this->viewFile = self::openView();
		$this->position = 0;
	}

	public function current()
	{
		if(! $this->line)
			$this->line = fgets($this->viewFile);

		return $this->line;	
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		if(!$this->ended){
			$this->line = self::getsLine();
			$this->position++;
		}
	}

	public function valid()
	{
		if($this->ended) return false;

		if(feof($this->viewFile))
			$this->ended = true;

		return true;
	}

	private function openView(){
		return fopen($this->viewPath, 'r');
	}

	private function closeView(){
		fclose($this->viewFile);
	}

	private function getsLine(){
		return fgets($this->viewFile);
	}
}
?>