<?php 
require_once("C:/xampp/htdocs/tamplate_new_site/assets/util/db.php");
class modelUsuario extends db{	
	function __construct(){}

	public function searchsCount($where){
		$this->openDb();
		$result = pg_query("SELECT count(*) total FROM usuario u		
 		$where;");
		$data = pg_fetch_array($result);
		$this->closeDb();
		return $data['total'];
	}

	public function searchs($paginar,$where){
		$this->openDb();
		$result = pg_query("SELECT id_usuario,nom nom_usuario, concat_ws(' ', nom,ap,am)nom_usu  FROM usuario
		$where 
		ORDER bY 2
		$paginar; ");
		$this->closeDb();
		return $result;
	}	

}
?>