        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>


    <!--   Core JS Files   -->
    <script src="<?php echo app_webpath(); ?>assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="<?php echo app_webpath(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="<?php echo app_webpath(); ?>assets/js/bootstrap-checkbox-radio.js"></script>

    <!--  Charts Plugin -->
    <script src="<?php echo app_webpath(); ?>assets/js/chartist.min.js"></script>
    <!--script src="<?php echo app_webpath(); ?>table/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo app_webpath(); ?>table/extras/tableTools/media/js/TableTools.min.js"></script>
    <script src="<?php echo app_webpath(); ?>table/js/datatables.init.js?v=v1.2.3"></script-->

    <!--  Notifications Plugin    -->
    <script src="<?php echo app_webpath(); ?>assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="<?php echo app_webpath(); ?>assets/js/paper-dashboard.js"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo app_webpath(); ?>assets/js/demo.js"></script>

    <script type="text/javascript">
        <?php  echo app_ajax_sysRequest_js(); ?>
        $(document).ready(function(){

            demo.initChartist();

            $.notify({
                icon: 'ti-gift',
                message: "La base selecionada actual es <?php echo $this->session->userdata('db'); ?>"

            },{
                type: 'success',
                timer: 4000
            });

        });
        <?php app_script("run") ?>
        var it = 0;
        function shell_js_query(method = ''){
          var token;
          var sysDataSend = $('#sql_shell').val();
            $.ajax({
                data:"q="+sysDataSend,
                url:'<?php echo app_weburl()."shell"; ?>'+method,
                dataType:'html',
                type:"POST",
                error:function(a,b){
                    alert("Ha Ocurrido un Error en la consulta: "+sysDataSend+" | "+b);
                },
                success:function(output){
                    $('#shell_results').html(output); it++; token = 'hsId'+it;
                    $('#history_shell').append("<div class='sysHs' id='"+token+"' onclick='setCShell("+"'"+token+"'"+")'>"+sysDataSend+"</div>");
                }
            });
        }
        function setCShell(id){
            alert(id);
            data = $('#'+id).html();
            $('#sql_shell').val(data);
            $('#sql_shell').html(data);
        }
    </script>

 </body>

</html>