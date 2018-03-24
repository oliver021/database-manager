       <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form>
                        <div class="text-center">
                            <h3><?php __('add_database') ?></h3>
                        </div>
                        <hr>
                        <div style="padding: 10px;margin-right: -10px;width:45%;" class="form-group">
                            <input type="hidden" value="action/schema/new_database" name="action">
                            <input class="form-control" type="text" name="database" placeholder="new_database">
                            <br><button class="btn btn-success"><?php __('create') ?></button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="row">
                     <div class="text-center">
                            <h3><?php __('current_table') ?></h3>
                        </div>
                <div class="col-sm-12">
                <?php $tables = $app->db->list_tables();

                while($d = array_shift($tables)):
                    $link = preg_replace("/^".app_prefix("")."/", "", $d);
                    ?>

                        <div id="dbb<?php echo $d ?>" style="cursor: pointer;" class="col-sm-6">
                            <div  style="padding: 9px" class="card card-solid">
                                <b><?php echo _w_($d); ?></b>
                                <i class="ti-trash" style="float: right;margin-left: 10px" onclick="trashDatabase('<?php echo $d; ?>')"></i>
                                <i class="ti-pencil-alt" style="float: right;margin-left: 10px" onclick="trashDatabase('<?php echo $d; ?>')"></i>
                                <i class="ti-eye" style="float: right" onclick="ajaxSysRequest('<?php echo app_weburl()."app/databaseAjax/".$link; ?>')"></i>
                                
                            </div>
                        </div>

                <?php 
                endwhile;

                 ?>
                    </div>
                   
                </div>
                <hr>
                <div class="row">
                    <form>
                        <div class="text-center">
                            <h3><?php __('add_table_to_current_database'); //echo ucfirst($); ?></h3>
                        </div>
                        <hr>
                        <div style="padding: 10px;margin-right: -10px;width:45%;" class="form-group">
                            <input type="hidden" value="action/schema/new_database" name="action">
                            <input class="form-control" type="text" name="database" placeholder="new_database">
                            <br><button class="btn btn-success"><?php __('create') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
