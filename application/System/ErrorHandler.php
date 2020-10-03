<?

namespace System;

use Exception;

class ErrorHandler
{
	public function register()
	{
		set_exception_handler([$this, 'exceptionErrorHandler']);
	}

	public function exceptionErrorHandler(Exception $e)
	{
		if($e->getCode() == 404){
			//(new ..\Controllers\errorController("error"))->action404();
			App::run("error","404", false);
			echo $e->getMessage();
			return true;
		}
		return false;
	}

}
