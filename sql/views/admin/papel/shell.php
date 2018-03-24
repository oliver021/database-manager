    <div class="content">
            <div class="container-fluid">
            <div class="row">
                    <div class="col-sm-6 from-group" style="padding: 12px">
                        <textarea id="sql_shell" class="form-control shell"></textarea>
                    </div>
                    <div id="history_shell" style="overflow-x: auto;max-height: 120px" class="col-sm-6" style="padding: 12px">
                    </div>
                    <br>
                    <div class="col-sm-12">
                    <button onclick="shell_js_query()" class="btn btn-primary"><?php  __("send_query") ?></button>
                    </div>
            </div>
            <hr>
             
            <div id="shell_results" class="row">
                    <?php 
                    

                    ?>

            </div>
            </div>
            </div>
        </div>
