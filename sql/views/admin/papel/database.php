       <div class="content">
            <div class="container-fluid">
              <div class="row" style="padding: 1%">
                 
                 <?php $app->load->database($app->session->userdata('db')); 
                $tables = $app->db->list_tables();
                while($d = array_shift($tables)):
                    $link = preg_replace("/^".app_prefix("")."/", "", $d);
                    ?>
                        <div style="cursor: pointer;" onclick="ajaxSysRequest('<?php echo app_weburl()."app/databaseAjax/".$link; ?>')" class="col-sm-2">
                            <div class="card card-solid"><p><?php echo _w_($d); ?></p></div>
                        </div>
                <?php 
                endwhile; ?>
                
                <hr>
                </div>
                <button onclick="ajaxSysRequest('<?php echo app_weburl()."app/ajaxApi?init=1&page=create&item=$name_table-new"; ?>')" class="btn btn-success"><?php __("insert") ?></button>
                <button onclick="ajaxSysRequest('<?php echo app_weburl()."app/struct"; ?>')" class="btn btn-primary"><?php __("Struct") ?></button>
                 <button onclick="ajaxSysRequest('<?php echo app_weburl()."app/struct"; ?>')" class="btn btn-primary"><?php __("Task") ?></button>
                <hr>
                <div class="row">
                    <?php 
                    $userdataType = '*';//"id,day,province,month,name,place";
                    $load = $app->db->query("SELECT $userdataType FROM ".$name_table."");
                    $data_user =$load->result("array");
                    if (is_null($data_user)) {
                        $data_use[0]=array();
                    }
                    echo admin_mk_table($name_table,_w_("manager_system_data"),$data_user,@array_keys(@$data_user[0])) ;

                    ?>

                    </div>
                </div>
            </div>
        </div>
