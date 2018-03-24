       <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <?php 

                    $app->load->database(); $userdataType = "id,name,email,content,time,ip";
                    $load = $app->db->query("SELECT $userdataType FROM ".app_prefix("comment")."");
                    $data_user =$load->result("array");
                    if (is_null($data_user)) {
                        $data_use[0]=array();
                    }
                    echo admin_mk_table("comment","system get content",$data_user,@array_keys(@$data_user[0])) ;

                    ?>


                </div>
            </div>
        </div>
