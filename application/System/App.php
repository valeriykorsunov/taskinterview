<?php

namespace System;

/**
 * Главный класс приложения
 *
 * @return void
 */
class App
{
	/**
	 * Запуск приложения
	 * 
	 * @throws \ErrorException если Controller или action не существует
	 */
	public static function run($controller = "home", $action = "index", $path = true)
	{
		$nameController = $controller;
		if ($path)
		{
			// Получаем URL запроса
			$path = $_SERVER['REQUEST_URI'];

			// Разбиваем URL на части
			$pathParts = explode('/', $path);
		}

		// Получаем имя контроллера
		if ($pathParts[1])
		{
			$controller = $pathParts[1];
		}

		// Получаем имя действия
		if ($pathParts[2])
		{
			$action = $pathParts[2];
		}

		// Формируем пространство имен для контроллера
		$controller = 'Controllers\\' . $controller . 'Controller';

		// Если класса не существует, выбрасывем исключение
		if (!class_exists($controller))
		{
			throw new \ErrorException('Controller "'.$controller.'" не существует', 404);
		}

		// Создаем экземпляр класса контроллера
		$objController = new $controller($nameController);

		// Формируем наименование действия
		$action = 'action' . ucfirst($action);
		// Если действия у контроллера не существует, выбрасываем исключение
		if (!method_exists($objController, $action))
		{
			throw new \ErrorException('action "' . $action . '" не существует', 404);
		}

		// Вызываем действие контроллера
		$objController->$action();
	}
}
