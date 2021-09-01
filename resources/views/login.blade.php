<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Jerson Martinez">
    <title>Inicio sesión | Optiglass</title>
    <link rel="apple-touch-icon" href="app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/login.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/custom/custom.css">
    <!-- END: Custom CSS-->
  </head>
  <!-- END: Head-->
  <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 1-column login-bg  blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">

    <!-- preloader-->
    <div id="preloader" class="preloader-background">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
                  <div class="circle-clipper left">
                    <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                    <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col s12">
        <div class="container"><div id="login-page" class="row">
          <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
            <form class="login-form" id="formLogin" method="post" action="login">
              <div class="row">
                <div class="input-field col s12">
                  <h5 class="ml-4">Inicio sesión</h5>
                </div>
              </div>
              @if(Session::has('mensaje_error'))
                <div class="col s12">
                    <div class='card-alert card gradient-45deg-red-pink'>
                      <div class='card-content white-text'>
                         <p><i class='material-icons'>error</i> ERROR: {{ Session::get('mensaje_error') }}</p>
                       </div>
                    </div>  
                 </div>   
              @endif
              {{ csrf_field() }}
              <div class="row margin">
                <div class="input-field col s12">
                  <i class="material-icons prefix pt-2">person_outline</i>
                  <input id="txtCodigo" name="codigo" type="text">
                  <label for="txtCodigo" class="center-align">Usuario (modificado desde Local)</label>
                </div>
              </div>
              <div class="row margin">
                <div class="input-field col s12">
                  <i class="material-icons prefix pt-2">lock_outline</i>
                  <input id="txtClave" name="clave" type="password">
                  <label for="txtClave">Password</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12" type="submit" name="action">Entrar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>
      </div>
    </div>

    <script src="app-assets/js/vendors.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="app-assets/js/plugins.js" type="text/javascript"></script>
    <script src="js/principal.js" type="text/javascript"></script>
    
  </body>
</html>