<?php

namespace Controllers;

use System\View;

/**
 * Главный контроллер приложения
 *
 */
class mainController extends Controller
{
	function actionLogout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}

	function actionLogin()
	{
		//$data["login_status"] = "";

		if(isset($_POST['login']) && isset($_POST['password']))
		{
			$login = $_POST['login'];
			$password =$_POST['password'];
			
			/*
			Производим аутентификацию, сравнивая полученные значения со значениями прописанными в коде.
			Такое решение не верно с точки зрения безопсаности и сделано для упрощения примера.
			Логин и пароль должны храниться в БД, причем пароль должен быть захеширован.
			*/
			if($login=="admin" && $password=="12345")
			{
				$data["login_status"] = "access_granted";
				
				session_start(); echo $_SESSION['admin'];
				$_SESSION['admin'] = $password;
				header('Location:'.$_SERVER['REQUEST_URI']);
			}
			else
			{
				$data["login_status"] = "access_denied";
			}
		}
		else
		{
			$data["login_status"] = "";
		}
		
		View::render($this->templateViwe, $this->dirViwe.'login',$data);
	}

}