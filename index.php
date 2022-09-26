<?php 
require_once("C:/xampp/htdocs/tamplate_new_site/assets/util/constans.php");
require_once(ASSETS_UTIL."util.php");
@session_start();

$util = new util();
$url = $util->clearurl($_SERVER['REQUEST_URI']);

if($url == 'logout'){
	include ASSETS_VIEW.'logout.php';
}

$tipo_usuario = 0;

if(isset($_SESSION['sesion']['datos_us']['id_usuario'])){
	$tipo_usuario = $_SESSION['sesion']['datos_us']['tipo_usuario'];
}

$param = $util->showview($url,$tipo_usuario);
if($param['view'] == 'sin_sesion'){
	header('Location: /'.DIRECTORY_PRINCIPAL.'/');
}
else{
	include(ASSETS_VIEW. $param['view']);
}
?>
