<?php  //function's to developer

function admin_mk_table($name,$about="",$data=array(),$keys=null,$m=false){
  ob_start();  ?>

                 <div class="col-md-12">
                        <div class="card card-solid">
                            <div class="header">
                                <h4 class="title"><?php echo _w_($name); ?></h4>
                                <p class="category"><?php echo $about; ?></p>
                            </div>
                            <div style="padding-left: -2px" class="content table-responsive table-full-width ">
                                <table class="dynamicTable table table-hover table-striped">
                                    <thead>
                                    <?php 
                                      if (!count($data)) {
                                        if ($m) {
                                          return "<h4>".$m."</h4>";
                                        } else {
                                        return __("not_have"." ".$name);
                                        }
                                        
                                        
                                    }
                                    if (is_null($keys)) {
                                        $header = array_keys($data);
                                    } else {
                                        $header = $keys;
                                    }
                                    $i=0;while($d = array_shift($header)):
                                            if($d == "id"):
                                                $setId = $i;
                                                continue;
                                            endif;
                                        $i++;
                                        echo '<th>'._w_($d).'</th>'."\n";
                                        endwhile; ?>
                                        <th><?php __("action") ?></th>
                                    </thead>
                                    <tbody>
                                    <?php while($d = array_shift($data)):
                                    $vatTokenCell = "idCell".mt_rand(1,600).@$d['id'];
                                      ?>
                                        <tr id="<?php echo $vatTokenCell ?>">
                                        <?php 
                                                  $header = array_keys($data);
                                                  for($c = 0;$c <count($d);$c++):
                                                    if (@$setId === $c) {
                                                        $idProperty = current($d);
                                                        next($d);continue;
                                                    }
                                                    $a = current($d); next($d);
                                                  if($a){echo '<td>'.$a.'</td>'."\n";
                                                   }else{
                                                  echo '<td>'._w_("null").'</td>';}
                                                  endfor;
                                        ?>
                                        <td>
                                        <i onclick="ajaxSysRequest('<?php echo app_weburl()."app/ajaxApi?init=1&page=update&item=$name-".@$idProperty; ?>')" class="ti-pencil button-i">
                                            
                                        </i> | <i onclick="ajaxSysDelete('<?php echo $name."-".@$idProperty; ?>','<?php echo $vatTokenCell ?>')" class="ti-trash button-i">
                                            
                                        </i></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  
    <?php return ob_get_clean();
}

