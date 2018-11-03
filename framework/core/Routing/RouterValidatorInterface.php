<?php 
namespace Framework\Core\Routing;

interface RouterValidatorInterface {
	public function takeAlfabetic();
	public function takeDigit();
	public function validateAll(array $arguments, array $requirements);
	public function validate(string $argument, $requirement);
}

?>