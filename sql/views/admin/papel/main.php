<body>
 <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
<div class="wrapper">
 
     <div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                SQL <span style="color: #34fe34">M</span>anager
                </a>
            </div>

            <ul class="nav">
               <?php echo $menu; ?>
            </ul>
    	 </div>
     </div>

     <div  class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                      
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification"><?php echo count($dbs); ?></p>
									<p><?php __("database") ?></p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu" style="max-height: width:auto; 150px;overflow-x: auto;">
                                <?php while($current = array_shift($dbs)): ?>
                                <li><a href="<?php echo app_weburl()."action/setdb/".$current; ?>"><?php echo $current; ?></a></li>
                                  <?php endwhile; ?>
                              </ul>
                        </li>
						<li>
                            <a href="#">
								<i class="ti-settings"></i>
								<p><?php __("setting") ?></p>
                            </a>
                        </li>
                          <li>
                            <a href="<?php echo app_weburl()."login/logout"; ?>">
                                <i class="ti-panel"></i>
                                <p><?php __("logout") ?></p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <br>
     	 <section  id="app_main_content">
            <?php echo $content  ?>  
         </section>
            
  
