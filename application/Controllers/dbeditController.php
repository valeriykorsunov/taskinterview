<?

namespace Controllers;

use Models\DB;

use System\View;

class dbeditController extends Controller
{
	public $menuSection;

	function __construct($nameController)
	{
		$this->view = new View;
		$this->addSettings($nameController);

		$this->view->vData["menuSection"] = array(
			array(
				"SORT"=>100,
				"NAME"=>"Добавить таблицу",
				"URL"=>"/dbedit/addTable/"
			),
			array(
				"SORT"=>100,
				"NAME"=>"Список таблиц БД",
				"URL"=>"/dbedit/tables/"
			),
			array(
				"SORT"=>100,
				"NAME"=>"SQL запрос текстом",
				"URL"=>"/dbedit/textSql/"
			),
		);
	}

	public function actionIndex()
	{
		
		$this->view->render($this->templateViwe, $this->dirViwe . 'index');
	}

	function actionTextSql()
	{
		if ($_POST['btn'])
		{
			$db = new DB;
			$resSqlQuery = $db->textSqlQuery($_POST["sqlQuery"]);
		}
		$this->vData["resSqlQuery"] = $resSqlQuery;

		$this->view->render($this->templateViwe, $this->dirViwe . 'textSql');
	}

	function actionTables()
	{
		$db = new DB;
		
		if($_GET['tableDrop'])
		{
			$db->tableDrop($_GET['tableDrop']);
		}
		
		$this->view->vData["allTable"] = $db->getAllTable();

		$this->view->render($this->templateViwe, $this->dirViwe . 'tables');
	}
	
	function actionEditTable()
	{
		// обязательно должен быть get парамтр с имнем таблицы
		if($_GET["table"])
		{
			$db = new DB;
			$db->getTableDada();
		}
		// все операции делать пост запросами. 
		$this->view->render($this->templateViwe, $this->dirViwe . 'editTable');
	}

	function actionAddTable()
	{
		$this->view->arJsFile[] = "/js/dbedit.js";

		if($_POST["btn"] == "Создать")
		{

			$tableName = $_POST["tableName"];
			$arColName = $_POST["name"];
			$arColTypeDate = $_POST["typeDate"]; 
			$arColAttribute = $_POST["attribute"];
			
			// создать таблицу
			$db = new DB;
			$result = $db->createTable($tableName, $arColName, $arColTypeDate, $arColAttribute);

			if($result === true){
				$this->view->vData["message"] = 'Таблица создана. <a href="/dbedit/tables/">Смотреть список таблиц.</a>';
			}
			else
			{
				$this->view->vData["error"] = $result[0]['error'];
			}
		}
		
		$this->view->render($this->templateViwe, $this->dirViwe . 'addTable');
	}
}
