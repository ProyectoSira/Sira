<!DOCTYPE HTML>
<html>
<head>
<title>Sira</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel='stylesheet' type='text/css'>
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/select/css/bootstrap-select.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/style.css')?>" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url('assets/css/font-awesome.css')?>" rel='stylesheet' type='text/css'>
<link href="<?php echo base_url('assets/css/icon-font.min.css')?>" rel='stylesheet' type='text/css'>
<!--<script src="js/Chart.js"></script>-->
<link href="<?php echo base_url('assets/css/animate.css')?>" rel='stylesheet' type='text/css'>


    


<script src="<?php echo base_url('assets/js/wow.min.js')?>"></script>
    <script>
         new WOW().init();
    </script>
<script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js')?>"></script>

</head> 
   
 <body class="sticky-header left-side-collapsed"  onload="initMap()">
    <section>
    <!-- left side start-->
        <div class="left-side sticky-left-side">

            <!--logo and iconic logo start-->
            <div class="logo">
                <h1><a href="<?php echo base_url()?>">SI<span>RA</span></a></h1>
            </div>
            <div class="logo-icon text-center">
                <a href="<?php echo base_url()?>"><i class="lnr lnr-home"></i> </a>
            </div>

            <!--logo and iconic logo end-->
            <div class="left-side-inner">

                <!--sidebar nav start-->
                    <ul class="nav nav-pills nav-stacked custom-nav">
                        <li><a href="<?php echo base_url('index.php/acudiente'); ?>">
                        <i class="glyphicon glyphicon-th"></i> <span> Matricula</span></a>
                        </li>
                        <li class="menu-list">
                            <a ><i class="lnr lnr-cog"></i>
                                <span>Configuracion</span></a>
                                <ul class="sub-menu-list">
                                    <li>
                                        <a href="<?php echo base_url('index.php/area'); ?>">Areas</a>
                                    </li>
                                     <li>
                                        <a href="<?php echo base_url('index.php/asignatura'); ?>">Asignaturas</a>
                                    </li>       
                                    <li>
                                        <a href="<?php echo base_url('index.php/periodo'); ?>">Periodos</a>
                                    </li>                             
                                    <li>
                                        <a href="<?php echo base_url('index.php/grado'); ?>">Grados</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('index.php/grupo'); ?>">Grupos</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('index.php/empleado'); ?>">Empleado</a>
                                    </li>                                  
                                    <li>    
                                        <a href="<?php echo base_url('index.php/asignacion'); ?>">Grupo de Estudio</a>
                                    </li>
                                </ul>
                        </li>
                        <li class="menu-list">
                            <a ><i class="glyphicon glyphicon-calendar"></i>
                                <span>Calendario</span></a>
                                <ul class="sub-menu-list">    
                                    <li>
                                        <a href="<?php echo base_url('index.php/calendario'); ?>">Calendario</a>
                                    </li> 
                                    <li>
                                        <a href="<?php echo base_url('index.php/periodo'); ?>">Periodos</a>
                                    </li>   
                                    <li>
                                        <a href="<?php echo base_url('index.php/programacion'); ?>">Programacion</a>
                                    </li>                          
                                </ul>
                        </li>
                        <li><a href="<?php echo base_url('index.php/asistencia'); ?>">
                        <i class="glyphicon glyphicon-check"></i> <span> Registro Asistencia</span></a>
                        </li>

                        <li><a href="<?php echo base_url(); ?>">
                        <i class="lnr lnr-list"></i> <span> Reportes</span></a>
                        </li>              


                        <li><a href="<?php echo base_url('index.php/sancion'); ?>">
                        <i class="glyphicon glyphicon-alert"></i> <span> Sanciones</span></a>
                        </li>  

                        <li><a href="<?php echo base_url(); ?>">
                        <i class="lnr lnr-paperclip"></i> <span> Planeacion</span></a>
                        </li>  

                    </ul>
                <!--sidebar nav end-->
            </div>
        </div>
        <!-- left side end-->
    
        <!-- main content start-->
        <div class="main-content">
            <!-- header-starts -->
            <div class="header-section">
             
            <!--toggle button start-->
            <a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--notification menu start -->
            <div class="menu-right">
                <div class="user-panel-top">    
                    <div class="profile_details_left">
                        <ul class="nofitications-dropdown">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge">3</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="notification_header">
                                                <h3>Tienes 3 notificacines nuevas</h3>
                                            </div>
                                        </li>
                                        <li><a href="#">
                                           <div class="notification_desc">
                                            <p>Lorem ipsum dolor sit amet</p>
                                            <p><span>1 hour ago</span></p>
                                            </div>
                                          <div class="clearfix"></div>  
                                         </a></li>
                                         <li class="odd"><a href="#">
                                           <div class="notification_desc">
                                            <p>Lorem ipsum dolor sit amet </p>
                                            <p><span>1 hour ago</span></p>
                                            </div>
                                           <div class="clearfix"></div> 
                                         </a></li>
                                         <li><a href="#">
                                           <div class="notification_desc">
                                            <p>Lorem ipsum dolor sit amet </p>
                                            <p><span>1 hour ago</span></p>
                                            </div>
                                           <div class="clearfix"></div> 
                                         </a></li>
                                         <li>
                                            <div class="notification_bottom">
                                                <a href="#">Ver todas las notificaciones</a>
                                            </div> 
                                        </li>
                                    </ul>
                            </li>                                               
                            <div class="clearfix"></div>    
                        </ul>
                    </div>
                    <div class="profile_details">       
                        <ul>
                            <li class="dropdown profile_details_drop">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <div class="profile_img">   
                                         <div class="user-name">
                                            <p>Michael<span>Administrator</span></p>
                                         </div>
                                         <i class="lnr lnr-chevron-down"></i>
                                         <i class="lnr lnr-chevron-up"></i>
                                        <div class="clearfix"></div>    
                                    </div>  
                                </a>
                                <ul class="dropdown-menu drp-mnu">
                                    <li> <a href="#"><i class="fa fa-cog"></i> Configuracion</a> </li> 
                                    <li> <a href="#"><i class="fa fa-user"></i>Perfil</a> </li> 
                                    <li> <a href="sign-up.html"><i class="fa fa-sign-out"></i> Cerrar Sesion</a> </li>
                                </ul>
                            </li>
                            <div class="clearfix"> </div>
                        </ul>
                    </div>      
                </div>
              </div>
            </div>

