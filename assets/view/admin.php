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
                <a class="navbar-brand" ><?=NEME_POYEC?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">                        
                        <li class="nav-item"><a class="nav-link" id="logout">Cerrar sesion</a></li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-4">
                <h6>Lista de usuario</h6>  
              </div>              
              <div class="col-md-6 p-4" style="text-align:right;">
                <h6>Total registros: <span id="total">0</span> Página <span id="pag_actual">0</span> de <span id="tota_pag">0</span></h6>
              </div>
                <div class="col-md-12">
                    <table class="table" id="usu">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">id</th>
                          <th scope="col">usuario</th>
                          <th scope="col">Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                                               
                      </tbody>
                    </table>
                </div>
                <div class="card-body px-0 pt-0 pb-2 tet-center" id="paginador"></div>
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
  $('#logout').on('click',function(){
     window.location= 'logout'; 
  });
});
</script>
<script type="text/javascript">
$(function(){     
    search(1);    
    $('#total_v').html('0');
    $('#total_c').html('0');
    $('#total_e').html('0');
});

function search(page) {
    $.ajax({
        url: 'ct/ctusu',
        data: {
        usu: 'p1202*3',
        page: page
        },
        dataType: "json",
        type: 'POST',
        beforeSend: function() {
            //$("#lockscreen").show();
        },
        success: function(data) {

        setTimeout(function() {
          $("#lockscreen").hide();
          $('#usu > tbody').html('');
          $('#paginador').html('');
          $('#total').html('0');
          $('#pag_actual').html('0');
          $('#tota_pag').html('0');

          $('#usu> tbody').append(data.html);
          $('#paginador').html(data.paginador);
          $('#total').html(data.total);
          $('#pag_actual').html(data.pagina_actual);
          $('#tota_pag').html(data.total_pag);
        }, 2000);
        },
        error: function(data) {
            //$("#lockscreen").hide();
        }
    });
}
</script>