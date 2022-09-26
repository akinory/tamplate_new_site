<?php 
require_once("C:/xampp/htdocs/tamplate_new_site/assets/util/constans.php");
require_once(ASSETS_UTIL."util.php");

$util = new util();

$data = $util->clearurlct($_SERVER['REQUEST_URI']);

$obj_datas = array(
	'ctusu' => 'ctUsuarios.php',		
);
if(isset($obj_datas[$data])){
	require_once(CT_PATH.$obj_datas[$data]);	
}
else{
	print json_encode(array("success"=>false, "msg"=>"502 no se encontro la petición."));
}
?>