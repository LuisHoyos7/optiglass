@extends('principal')

@section('content')
    
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
       <div class="container">
        <div class="row">
          <div class="col s6">
            <h5 class="breadcrumbs-title mt-0 mb-0">Quejas</h5>
           </div>
          
        </div>
      </div>
     </div>
  
    
        <div class="col s12">
          <div class="container">
            <div class="section">
        
        <div class="row">
          <div class="col s12">
            <div id="validations" class="card card-tabs">
              <div class="card-content">
            
                <div id="view-validations">

                    <form class="formValidate" id="formQueja" method="post">
                        {{ csrf_field() }} 
                        <div class="row">
                          <div class="input-field col s6 m2 offset-s6 offset-m10">
                            <label for="txtNumero">Número</label>
                            <input readonly id="txtNumero" name="numero" type="text" placeholder=" ">
                          </div>
                        </div>

                        <div class="row">
                          <div class="input-field col s9 m5">
                            <label for="txtConsecutivo">Consecutivo</label>
                            <input id="txtConsecutivo" name="consecutivo" type="text" data-error=".errorTxt1" placeholder=" ">
                            <div class="errorTxt1"></div>
                          </div>

                          <div class="input-field col s3 m1">
                            <button id="btnBuscar" class="btn btn-floating waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="button" name="action">
                          <i class="material-icons right">search</i>
                          </button>
                          </div>

                          <div class="input-field col s12 m6">
                            <label for="txtNumeroDocumento">No documento</label>
                            <input readonly id="txtNumeroDocumento" name="numeroDocumento" type="text"  placeholder=" ">
                          </div>
                        </div>

                        <div class="row">
                          <div class="input-field col s12 m6">
                            <label for="txtNombres">Nombres</label>
                            <input readonly id="txtNombres" name="nombres" type="text" placeholder="">
                          </div>
                      
                          <div class="input-field col s12 m6">
                            <label for="txtApellidos">Apellidos</label>
                            <input readonly id="txtApellidos" name="apellidos" type="text" placeholder="">
                          </div>
                        </div>
                        
                      
                        <div class="row">
                          <div class="input-field col s12 m6">
                            <label for="txtPromotor">Promotor</label>
                            <input readonly id="txtPromotor" name="promotor" type="text" placeholder="">
                            <div class="errorTxt6"></div>
                          </div>

                          <div class="input-field col s12 m6">
                            <label for="txtBrigada">Brigada</label>
                            <input readonly id="txtBrigada" name="brigada" type="text" placeholder="">
                          </div>
                        </div>


                        <div class="row">
                          <div class="col s12 m6">
                               <label for="cmbError">Error</label>
                               <select class="error browser-default" id="cmbError" name="error" data-error=".errorTxt2">
                               </select>
                               <div class="input-field">
                                <div class="errorTxt2"></div>
                               </div>
                            </div>

                          <div class="col s12 m6">
                            <label for="cmbEstado">Estado</label>
                            <select class="error browser-default" id="cmbEstado" name="estado" data-error=".errorTxt3">
                              <option value="" disabled selected>Seleccione</option>
                              <option value="A">Activo</option>
                              <option value="I">Inactivo</option>
                            </select>
                            <div class="input-field">
                              <div class="errorTxt3"></div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col s12">

                            <table id="data-table-simple" class="cell-border" style="width: 100%;border-top: solid 0.5px;">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Número</th>
                                  <th>Error</th>
                                  <th>Estado</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                                              
                        <div class="input-field col s12 m3 l3 xl2 offset-m6 offset-l6 offset-xl8">  
                          <button id="btnGuardar" class="col s12 btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="submit" name="action">Guardar
                          <i class="material-icons right">save</i>
                          </button>
                        </div>
                        
                         <div class="input-field col s12 m3 l3 xl2">  
                           <button id="btnNuevo" class="col s12 btn waves-effect waves-light submit gradient-45deg-indigo-purple gradient-shadow" type="button" name="action">Nuevo
                          <i class="material-icons right">add_box</i>
                          </button> 
                        </div>

                      </form>
                 </div>
             
              </div>
            </div>            
          </div>
        </div>
                
      </div>  
    </div>
  </div>



  <!-- Scripts -->
  <script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="js/quejas.js" type="text/javascript"></script>
  <script src="app-assets/js/scripts/data-tables.js" type="text/javascript"></script>
      
@endsection 
