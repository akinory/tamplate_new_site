<?php
@session_start();
if (!isset($_SESSION['sesion']['datos_us']['id_usuario'])) {
    print json_encode(array("success" => false, "msg" => "Su sesión ha finalizado, Vuelva a ingresar"));
    exit;
}

switch (isset($_POST)){
    case isset($_POST["usu"]):
        search();
    break;   
    default:
        print json_encode(array("success"=>false,"msg"=>"Método no encontrado 502"));
    break;
}

function search(){
    global $util;
    $where = [];
   
    $page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
    $per_page = 12; //la cantidad de registros que desea mostrar
    $adjacents  = 2; //brecha entre páginas después de varios adyacentes
    $paginar =  ($page == 1) ? "LIMIT " . $per_page : "LIMIT " . $per_page . " OFFSET " . (($page - 1) * $per_page);
    $offset = ($page - 1) * $per_page;  
    
    if (count($where) > 0) {
        $where = ' WHERE ' . implode(" AND ", $where);
    }
    else{
       $where = '';
    }

    require_once(MODEL_PATH . 'modelUsuario.php');
    $model = new modelUsuario();
    $numrows  = $model->searchsCount($where);

    $total_pages = ceil($numrows / $per_page);
    $reload = '';
    $funcion = 'searchProductos';
    $html = '';

    if ($numrows > 0) {
        $result = $model->searchs($paginar, $where);

        while ($data = pg_fetch_array($result)) {

            // $id_productos = $data['id_productos'];
            $id_usuario = $data['id_usuario'];
            $nom_usuario = $data['nom_usuario'];
            $nom_usu = $data['nom_usu'];
            $html .= '<tr>
                          <th scope="row">1</th>
                          <td>'.$id_usuario .'</td>
                          <td>'.$nom_usuario.'</td>
                          <td>'.$nom_usu.'</td>
                        </tr>';
        }
        $paginador = $util->paginate($funcion, $reload, $page, $total_pages, $adjacents);
    } 
    else {
        $html .= '
        ';
        $paginador = '';
    }

    print json_encode(array("success" => true, "html" => $html, "paginador" => $paginador, "total" => $numrows, "pagina_actual" => $page, "total_pag" => $total_pages));
}
?>