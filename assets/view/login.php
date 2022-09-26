<?php 
  @session_start();
  $acceso = 0;
  $msg_error = "";
  $css_error = '';

  if(isset($_SESSION['sesion']['datos_us']) > 0){
    $acceso = 1;
  }
  elseif(isset($_POST['email']) && isset($_POST['password'])){
    require_once(ASSETS_UTIL."db.php");
    $bd = new db();
    
    $user = pg_escape_string(trim($_POST['email']));
    $pass = pg_escape_string(trim($_POST['password']));
    
    $bd->openDb();
    echo "SELECT id_usuario,nom nom_usuario, concat_ws(' ', nom,ap,am)nom_usu ,fk_id_cat_tipo_usuario tipo_usuario FROM usuario WHERE pass = md5('$pass') AND correo = '$user';";
    $result = pg_query("SELECT id_usuario,nom nom_usuario, concat_ws(' ', nom,ap,am)nom_usu ,fk_id_cat_tipo_usuario tipo_usuario FROM usuario WHERE pass = md5('$pass') AND correo = '$user';");
    if(pg_num_rows($result) > 0){
      $data = pg_fetch_array($result);
      $_SESSION['sesion']['datos_us']['id_usuario'] = $data['id_usuario'];
      $_SESSION['sesion']['datos_us']['nom_usu'] = $data['nom_usu'];
      $_SESSION['sesion']['datos_us']['tipo_usuario'] = $data['tipo_usuario'];
      $_SESSION['sesion']['datos_us']['nom_usuario_desc'] = $data['nom_usuario'];
      $acceso = 1;
      
      /*$result_usu_img = pg_query("SELECT i.archivo_ruta, i.archivo_tipo, i.archivo_nombre,c.tipo_usuario
      FROM usuario u      
      LEFT JOIN cat_tipo_usuario c ON c.id_cat_tipo_usuario = u.fk_id_cat_tipo_usuario
      LEFT JOIN usuario_detalle ud ON ud.fk_id_usuario = u.id_usuario
      LEFT JOIN img_system i ON i.id_img_system = ud.fk_id_img_system
      WHERE id_usuario = '$data[id_usuario]'; ");

      $data_usu_img = pg_fetch_array($result_usu_img);

      $archivo_ruta = $data_usu_img['archivo_ruta'];
      $archivo_tipo = $data_usu_img['archivo_tipo'];
      $archivo_nombre = $data_usu_img['archivo_nombre'];
      $tipo_usuario_desc = $data_usu_img['tipo_usuario'];
      $_SESSION['sesion']['datos_us']['tipo_usuario_desc'] = $tipo_usuario_desc;
      $_SESSION['sesion']['datos_us']['img'] = 'assets/img/team-2.jpg';

      if($archivo_ruta != ''){
          if(file_exists(FILES_SYTEM.$archivo_ruta)){
              $datimg = base64_encode(file_get_contents(FILES_SYTEM.$archivo_ruta));
              $ext_img = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
              $_SESSION['sesion']['datos_us']['img'] = "data:image/".$ext_img.";base64, ".$datimg;    
          }                
      }*/
    }
    else{
     $msg_error = "Datos incorrectos";
     $css_error = 'is-invalid';
    }

    $bd->closeDb();
  }  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?=NEME_POYEC?></title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="assets/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand"><?=NEME_POYEC?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/<?=DIRECTORY_PRINCIPAL?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="login">Iniciar secion</a></li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
          <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form id="form_login" action="login" method="POST">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email" name="email" class="form-control" name="email-address" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password"  name="password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                

                                
                                <?php 
                                  if($msg_error != ''){
                                ?>
                                     <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger text-center" role="alert">
                                            <strong>Aviso!</strong> <?=$msg_error?>
                                          </div>
                                        </div>
                                    </div>
                                <?php 
                                  }
                                ?>   
                                <div class="col-md-6 offset-md-4">
                                     <button id="btn_login" type="button" class="btn bg-gradient-success">Ingresar</button>                                  
                                </div>                        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
<script src="assets/js/jQuery.js"></script>
<script type="text/javascript">
    $(function(){
      var ac = '<?=$acceso?>';
      if(ac > 0){
        window.location = '/<?=DIRECTORY_PRINCIPAL?>';
      }

      $('#btn_login').on('click', function(){
        correo = $('#email').val();
        pass = $('#password').val();

        $('#email').removeClass('is-invalid');
        $('#email').removeClass('is-valid');

        $('#password').removeClass('is-invalid');
        $('#password').removeClass('is-valid');

        if(correo.trim() == ''){
          $('#email').addClass('is-invalid');
        }
        else{
          $('#email').addClass('is-valid'); 
        }
        if(pass.trim() == ''){
          $('#password').addClass('is-invalid');
        }
        else{
          $('#password').addClass('is-valid'); 
        }

        if(correo != '' && pass != ''){
          $('#form_login').submit();
        }
        
      });
    });
  </script>
