       <div class="content">
            <div class="container-fluid">
                <div class="row">
                        <div id="toolBar" class="row">
                            
                        </div>
                        <div class="col-sm-10">
                            <ul class="nav nav-tabs">
                                <li><a href="#tab1" data-toggle="tab">Actions</a></li>
                                <li><a href="#tab2" data-toggle="tab">Property</a></li>
                                <li><a href="#tabservice" data-toggle="tab">Services</a></li>
                                <li><a href="#tab3" data-toggle="tab">Debbugs</a></li>
                            </ul>
                            <div class="tab-content">
                             <div class="tab-pane active  sys-panel" id="tab1">

                               <form id="sysDeveloper" onsubmit="ajaxUpdateController('sysDeveloper');return false" class="row sys-form">
                               <div id="toolBarController" style="max-height: 50px;padding: 0px" class="card-solid">
                                    <i class="ti-server"></i>
                                    <select>
                                        <option onclick="sqlAction('custom')" ><?php __("sql_query","+") ?></option>
                                        <option onclick="sqlAction('select')" ><?php __("select") ?></option>
                                        <option onclick="sqlAction('update')" ><?php __("update") ?></option>
                                        <option onclick="sqlAction('insert')" ><?php __("insert") ?></option>
                                        <option onclick="sqlAction('delete')" ><?php __("delete") ?></option>
                                    </select>
                                    <i class="ti-plus"></i>
                                    <select>
                                        <option onclick="plusElm('custom')" ><?php __("var","+") ?></option>
                                        <option onclick="plusElm('select')" ><?php __("const") ?></option>
                                        <option onclick="plusElm('update')" ><?php __("loop") ?></option>
                                        <option onclick="plusElm('insert')" ><?php __("hook") ?></option>
                                        <option onclick="plusElm('delete')" ><?php __("call") ?></option>
                                    </select>
                                    <i title="<?php __("") ?>" class="ti-hand-open"></i>
                                    <i title="<?php __("Crear un gancho") ?>" class="ti-link"></i>
                                    <i title="<?php __("Crear un bloqueo") ?>" class="ti-lock"></i>
                                    <i title="<?php __("Cargar Datos de entrada") ?>" class="ti-import"></i>
                                    <i title="<?php __("Guardar Datos") ?>" class="ti-save"></i>
                                    
                                    <i title="<?php __("Checkear Datos") ?>" class="ti-eye"></i>
                                    <i title="<?php __("Realizar un conexion") ?>" class="ti-world"></i>
                                    <i title="<?php __("Llamar a una Funcion") ?>" class="ti-announcement"></i>
                                    <i title="<?php __("Finalizar Datos") ?>" class="ti-check"></i>
                                    <input style="height: 30px" class="btn btn-primary" type="submit" value="<?php __('update') ?>">
                               </div>
                                        <hr style="height: 1px">
                                        <p><?php echo _w_("set_actions_your_controller").": current"; ?></p>
                                       
                                        <hr>
                               </form>


                              </div>
                              <div class="tab-pane sys-panel" id="tab2">Texto tab 2

                              </div>
                              <div class="tab-pane sys-panel" id="tab3">Texto tab 3

                              </div>

                              <div class="tab-pane sys-panel" id="tabservice"><?php echo _w_("here_is_service") ?>

                              </div>
                            </div>                          
                             

                         </div>
                         <div class="col-sm-3" >
                    
                        </div>
                </div>
            </div>
        </div>
