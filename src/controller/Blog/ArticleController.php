<?php 
namespace Controller\Blog;
use Framework\Fundamentals\MVC\Controller;
/**
 * summary
 */
class Article extends Controller
{
	public function name($articleId)
	{
		print "Inside Article:name " . $articleId; 
	}

	public function index($articleId)
	{
		print "Inside Article:index " . $articleId;
	}

	public function nonso($arg1, $arg2){
		print "Inside Article:nonso " . $arg1 . ' ' . $arg2;
	}
}

?>