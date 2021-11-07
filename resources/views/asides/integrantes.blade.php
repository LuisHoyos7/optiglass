<!-- START RIGHT SIDEBAR NAV -->
<aside id="right-sidebar-nav">
    <div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation">
        <div class="row">
            <div class="slide-out-right-title">
                <div class="col s12 border-bottom-1 pb-0 pt-1">
                    <div class="row">
                        <div class="col s2 pr-0 center">
                            <i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
                        </div>
                        <div class="col s10 pl-0">
                            <h5>Integrantes</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide-out-right-body">
                <div class="col s12">
                    <div class="card card-tabs">
                        <div class="card-content fixed-header" style="height: 200px;">
                            <table class=" striped highlight" id="tblIntegrante">
                                <thead>
                                    <tr>
                                        <th>Consecutivo</th>
                                        <th>Nombre</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col s12">

                    <form class="formValidate" id="formIntegrante" method="post">

                        {{ csrf_field() }}
                        <div class="input-field col s12">
                            <label for="txtConsecutivoIntegrante">Consecutivo</label>
                            <input id="txtConsecutivoIntegrante" name="consecutivo" type="text" maxlength="10" data-error=".errorTxt13" placeholder=" ">
                            <div class="errorTxt13"></div>
                        </div>

                        <div class="input-field col s12">
                            <label for="txtNumeroDocumentoIntegrante">No documento</label>
                            <input id="txtNumeroDocumentoIntegrante" name="numeroDocumento" type="text" maxlength="20" placeholder=" ">
                        </div>

                        <div class="input-field col s12">
                            <label for="txtNombresIntegrante">Nombres</label>
                            <input id="txtNombresIntegrante" name="nombres" type="text" data-error=".errorTxt14" maxlength="50" placeholder="">
                            <div class="errorTxt14"></div>
                        </div>

                        <div class="input-field col s12">
                            <label for="txtApellidosIntegrante">Apellidos</label>
                            <input id="txtApellidosIntegrante" name="apellidos" type="text" data-error=".errorTxt15" maxlength="50" placeholder="">
                            <div class="errorTxt15"></div>
                        </div>

                        <div class="input-field col s12">
                            <label for="txtEdadIntegrante">edad</label>
                            <input id="txtEdadIntegrante" name="edad" type="text" data-error=".errorTxt15" maxlength="50" placeholder="">
                            <div class="errorTxt15"></div>
                        </div>

                        <div class="input-field col s6">
                            <label for="txtAbonoIntegrante">Abono</label>
                            <input id="txtAbonoIntegrante" name="abono" type="number" data-error=".errorTxt16" maxlength="10" placeholder=" " min="1">
                            <div class="errorTxt16"></div>
                        </div>

                        <div class="input-field col s6">
                            <label for="txtSaldoIntegrante">Saldo</label>
                            <input readonly id="txtSaldoIntegrante" name="saldo" type="number" data-error=".errorTxt17" maxlength="10" placeholder=" ">
                            <div class="errorTxt17"></div>
                        </div>

                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light right submit
                            gradient-45deg-indigo-purple gradient-shadow" id="btn-add" 
                            type="submit">Agregar
                                <i class="material-icons right">add</i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</aside>
<!-- END RIGHT SIDEBAR NAV -->

<!-- Dropdown Structure -->


<!-- Scripts -->
<script src="js/integrantes.js" type="module"></script>