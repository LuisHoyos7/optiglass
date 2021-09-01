<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
  <meta name="author" content="ThemeSelect">
  <title>Collapsibles | Materialize - Material Design Admin Template</title>

  <!-- Favicons-->
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/favicon/favicon-32x32.png">
  <link rel="apple-touch-icon" href="app-assets/images/favicon/apple-touch-icon-152x152.png">
  <!-- Icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

  <!-- BEGIN: VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/flag-icon/css/flag-icon.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/data-tables/css/select.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/data-tables/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/sweetalert/sweetalert.css">
  <!-- END: VENDOR CSS-->
  <!-- BEGIN: Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/materialize.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/themes/vertical-modern-menu-template/style.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/pages/data-tables.css">
  <!-- END: Page Level CSS-->
  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/custom/custom.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/custom/responsive.css">
  <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns  " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

  <!-- BEGIN VENDOR JS-->
  <script src="app-assets/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="app-assets/vendors/jquery-validation/jquery.validate.min.js"></script>
  <script src="app-assets/vendors/sweetalert/sweetalert.min.js"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN THEME  JS-->
  <script src="app-assets/js/plugins.js" type="text/javascript"></script>
  <script src="js/principal.js" type="text/javascript"></script>
  <!-- END THEME  JS-->

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

  <div id="alerta"></div>

  <!-- BEGIN: Header-->
  <header class="page-topbar" id="header">
    <div class="navbar navbar-fixed">
      <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">

      </nav>
    </div>
  </header>
  <!-- END: Header-->

  <!-- BEGIN: SideNav-->
  <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
      <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="/"><img src="app-assets/images/logo/logo-opti-glass-nuevo.png" /></a><a class="navbar-toggler" href="#"></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
      @if(Session::has('permisos'))
      @foreach(Session::get('permisos') as $permiso)
      @if($permiso->descripcion == 'afiliaciones')
      <li class="bold"><a class="waves-effect waves-cyan " href="afiliaciones"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Afiliación</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'revisionAfiliaciones')
      <li class="bold"><a class="waves-effect waves-cyan " href="revision"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Revisión</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'cargarMaletines')
      <li class="bold"><a class="waves-effect waves-cyan " href="cargarmaletines"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Cargar maletines</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'maletin')
      <li class="bold"><a class="waves-effect waves-cyan " href="callsdealer"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Maletín</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'asistencias')
      <li class="bold"><a class="waves-effect waves-cyan " href="asistencias"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Asistencia</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'ventas')
      <li class="bold"><a class="waves-effect waves-cyan " href="ventas"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Ventas</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'entregas')
      <li class="bold"><a class="waves-effect waves-cyan " href="entregas"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Entregas</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'quejas')
      <li class="bold"><a class="waves-effect waves-cyan " href="quejas"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Quejas</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'gastosGanancias')
      <li class="bold"><a class="waves-effect waves-cyan " href="gastosganancias"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Gastos y ganancias</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'liquidacion')
      <li class="bold"><a class="waves-effect waves-cyan " href="liquidacion"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Liquidación</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'reportesLiquidacion')
      <li class="bold"><a class="waves-effect waves-cyan " href="reportesLiquidacion"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Reportes de liquidación</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'tiposLentes')
      <li class="bold"><a class="waves-effect waves-cyan " href="lentes"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Tipos de lentes</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'brigadas')
      <li class="bold"><a class="waves-effect waves-cyan " href="brigadas"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Brigadas</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'estados')
      <li class="bold"><a class="waves-effect waves-cyan " href="estados"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Estados</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'subestados')
      <li class="bold"><a class="waves-effect waves-cyan " href="subestados"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Subestados</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'parametrosGastos')
      <li class="bold"><a class="waves-effect waves-cyan " href="parametros"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Parámetros</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'errores')
      <li class="bold"><a class="waves-effect waves-cyan " href="errores"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Errores</span></a>
      </li>
      @endif
      @if($permiso->descripcion == 'usuarios')
      <li class="bold"><a class="waves-effect waves-cyan " href="usuarios"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Usuarios</span></a>
      </li>
      @endif
      @endforeach
      @endif
      <li class="bold"><a class="waves-effect waves-cyan " href="logout"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="">Cerrar sesión</span></a>
      </li>
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
  </aside>
  <!-- END: SideNav-->

  <!-- BEGIN: Page Main-->
  <div id="main">
    <div class="row">
      <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>

      @yield('content')

    </div>
  </div>

  <!-- END: Page Main-->


</body>

</html>