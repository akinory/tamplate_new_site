<?php 
/**
* @author D.A.O.C.
* @version 1.0 vioTec
* @date 2022-04-10
*/	
class util 
{	
	function __construct(){}

    //$api = 'AIzaSyDXGhdUwAXfkndws4fpftgH81Ntp6e2bg4';

	public function clearurl($uri){     
        $uri = substr($uri, 1);
        $uri = str_replace(DIRECTORY_PRINCIPAL.'/','',$uri);
        return $uri;
    }

    public function clearurlct($uri){
        $uri = substr($uri, 1);
        $uri = str_replace(DIRECTORY_PRINCIPAL.'/'.DIREC_DATAS.'/','',$uri);
        return $uri;
    }

	/*Cifrado asimetrico*/    	
    public function Crypt($key,$data){
        $method = 'AES-128-CBC'; 
        $mienc = @openssl_encrypt($data, $method, $key);
        return base64_encode($mienc);
    }
	/*Cifrado asimetrico*/	
    public function Decrypt($key,$data){
        $method = 'AES-128-CBC'; 
        $midec = @openssl_decrypt(base64_decode($data),$method, $key);
        return $midec;
    } 

    public function showview($url,$tipo_usuario){
        @session_start();
        $view   = '';
        $param  = '';
        $alias  = '';

        switch ($url){
            case 'login':
                $view = 'login.php';
            break;
            
            case 'registro':
                $view = 'reg_cliente.php';
            break;

            case 'compania':
                $view = 'inicio/compania.php';
            break;

            case 'equipo':
                $view = 'inicio/equipo.php';
            break;

            case 'servicios':
                $view = 'inicio/servicios.php';
            break;

            case 'sobrenosotros':
                $view = 'inicio/sobrenosotros.php';
            break;

            case 'terminocondiciones':
                $view = 'inicio/terminocondiciones.php';
            break;

            default:
                
                if($url != ''){
                    
                    $alias = $this->vistaDecryp($url);                                         

                    if($alias != ''){
                        $create_day_date = date("Y-m-d");          
                        $alias_obj = explode("|", $alias);                    

                        if(is_array($alias_obj)){
                            $create_day_date_param = $alias_obj[0];
                            $alias = @$alias_obj[1];
                            $param = isset($alias_obj[2]) ? $alias_obj[2] : '';
                        }

                        if(!isset($_SESSION['sesion']['datos_us']['id_usuario'])){
                           $view = 'sin_sesion';
                        }
                        elseif($create_day_date_param == $create_day_date){
                            switch ($alias) {
                                case 'usuarios':
                                    $view = 'usuarios.php';
                                break;

                                case 'productos':
                                    $view = 'productos.php';
                                break;

                                case 'consultakardex':
                                    $view = 'consultaKardex.php';
                                break;

                                case 'consultaexistencia':
                                    $view = 'consultaExistencia.php';
                                break;

                                case 'compraproductos':
                                    $view = 'compraproductos.php';
                                break;
                                
                                case 'carrito':
                                    $view = 'carrito.php';
                                break;

                                case 'asignaOperador':
                                    $view = 'asignaOperador.php';
                                break;

                                case 'historialpedcliente':
                                    $view = 'historialpedcliente.php';
                                break;                                

                                default:
                                break;
                            }
                        }
                        else{
                             $view = 'error_page/502.php';
                        }                        
                    }
                    else{
                        $view = 'error_page/502.php';
                    }                   
                }
                else{
                                        
                    if($tipo_usuario > 0){

                        if(!isset($_SESSION['sesion']['datos_us']['id_usuario'])){
                           $view = 'sin_sesion';
                        }
                        else{
                            switch ($tipo_usuario){
                                case '1'://admin
                                    $view = 'admin.php';
                                break;

                                case '2'://Administrativo
                                    $view = 'administrativo.php';
                                break;

                                case '3'://Cliente
                                    $view = 'cliente.php';
                                break;

                                case '4'://Operador
                                    $view = 'operador.php';
                                break;

                                default:
                                    $view = 'inicio.php';
                                break;
                            }   
                        }                                                
                    }
                    else{
                        if($url == ''){
                            $view = 'inicio.php';
                        }
                        else{
                            $view = 'error_page/502.php';    
                        }
                        
                    }                
                }
                                                                           
            break;
        }
        

        return array('view' =>$view, 'param' => $param);
    }

    public function vistaCryp($url){
        $create_day_date = date("Y-m-d");        
        return $this->Crypt(KEY_SYSTEM,$create_day_date.'|'.$url);
    }

    public function vistaDecryp($url_enccryp){        
        return $this->Decrypt(KEY_SYSTEM,$url_enccryp);
    }

    public function paginate($funcion,$reload, $page, $tpages, $adjacents) {
        $prevlabel = "&lsaquo;";
        $nextlabel = "&rsaquo;";
        $out = '<nav>
                    <ul class="pagination justify-content-center pagination-warning">';

        // previous label
        if($page==1) {
            $out.= "<li class='page-item disabled'><span><a class='page-link'>$prevlabel</a></span></li>";
        } else if($page==2) {
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>$prevlabel</a></span></li>";
        }else{
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(".($page-1).")'>$prevlabel</a></span></li>";
        }
        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>1</a></li>";
        }
        // interval
        if($page>($adjacents+2)) {
            $out.= "<li class='page-item'><a class='page-link'>...</a></li>";
        }

        // pages
        $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
        
        $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
        for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$page) {
                $out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
            }else if($i==1) {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>$i</a></li>";
            }else {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(".$i.")'>$i</a></li>";
            }
        }

        // interval
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li class='page-item'><a class='page-link'>...</a></li>";
        }

        // last
        if($page<($tpages-$adjacents)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion($tpages)'>$tpages</a></li>";
        }

        // next
        if($page<$tpages) {
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(".($page+1).")'>$nextlabel</a></span></li>";
        }else {
            $out.= "<li class='page-item disabled'><span><a class='page-link'>$nextlabel</a></span></li>";
        }
        
        $out.= "</ul></nav>";
        return $out;
    }

    public function fileUpload($filePost,$rdi = true, $pixelRed = 1000 ){
        $fl_error  = $_FILES[$filePost]['error'];
        if ($fl_error > 0) {
            switch ($fl_error) {
                case UPLOAD_ERR_INI_SIZE:
                    $err_fl = "El archivo excede el tamaño permitido."; // 1: Upload excede la directiva upload_max_filesize en php.ini.
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $err_fl = "El archivo excede el tamaño especificado.";// 2: Upload excede la directiva MAX_FILE_SIZE que fue especificada en el form HTML.
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $err_fl = "El archivo fue sólo parcialmente cargado, intente de nuevo.";//3: Upload fue sólo parcialmente cargado.
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $err_fl = "No se especifico ningún archivo.";// 4: Ningún archivo fue subido.
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    error_log("carpeta temporal");
                    $err_fl = "Error en la carga de documento, por favor intente más tarde.";// 6: Falta la carpeta temporal | permisos?
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $err_fl = "No se pudo guardar el archivo.";// 7: No se pudo escribir el archivo en el disco.
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $err_fl = "Error en el servidor.";// 8: Una extensión de PHP detuvo la carga de archivos.
                    break;
            }
            $fileRet = array("name"=>"","type"=>"","tmp_name"=>"","size"=>"","fext"=>"","error"=>$err_fl,"err"=>1);
        } 
        else{
            $a_name = $_FILES[$filePost]['name'];
            $a_type = $_FILES[$filePost]['type'];
            $a_tmp  = $_FILES[$filePost]['tmp_name'];
            $a_size = $_FILES[$filePost]['size'];
            $a_ext  = strtolower(pathinfo($_FILES[$filePost]['name'], PATHINFO_EXTENSION));
                        
            $fileRet = array(
                "name"     => $a_name,
                "type"     => $a_type,
                "tmp_name" => $a_tmp,
                "size"     => $a_size,
                "extension"=> $a_ext,
                "error"    => $fl_error,
                "err"      => 0
            );
        }
        return $fileRet;
    }
}
?>