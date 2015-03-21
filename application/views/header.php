<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Computer Science Stock</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/plugins/metisMenu/metisMenu.min.css') ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/sb-admin-2.css') ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/font-awesome-4.1.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Computer Science Stock</a>
            </div>

            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url("login/logout") ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                <?php 
                
                $ci = &get_instance();      

                $permission = $ci->session->userdata("permission");
                $this->class = $this->router->fetch_class(); // class = controller
                printMenu($permission);
                function printMenu($permission){
//                    $parentCode = "";
//                    $parent = array_shift($permission);
//                    foreach ($permission as $parent) {
                    for ($i=0; $i<count($permission); $i++) {
                        $parent = $permission[$i];
                        $menu_page_code = $parent["menu_page_code"];
                        $menu_page_name = $parent["menu_page_name"];
                        $menu_page_link = $parent["menu_page_link"];
                        $icon = $parent["icon"];

                        $parentCode = substr($menu_page_code, 0, 2);
                        $output = ""; 
                        $active = "";
//                        $output .= " <li class='active'> ";
                        $output .= " <a href='" . base_url($menu_page_link) . "'>$icon $menu_page_name";
                        
                        if(!empty($permission)){
                            
                            $child = $permission[$i + 1];
                            $child_menu_page_code = $child["menu_page_code"];
                            $childCode = substr($child_menu_page_code, 0, 2);
                            if($parentCode === $childCode){
                                $output .= "<span class='fa arrow'></span></a> ";
                                $output .= '<ul class="nav nav-second-level">';
                                
                                for ($i= ++$i; $i < count($permission); $i++) {
                                    $child = $permission[$i];
                                    $child_menu_page_code = $child["menu_page_code"];
                                    $childCode  = substr($child_menu_page_code, 0, 2);

                                    if($parentCode == $childCode){
                                        
                                        $child_menu_page_name = $child["menu_page_name"];
                                        $child_menu_page_link = $child["menu_page_link"];
                                        $child_icon = $child["icon"];
                                        $is_selected = $child["is_selected"];
                                        if($is_selected === "1"){
                                             $active = " class='active'";
                                        }
                                        $output .= " <li> ";
                                        $output .= " <a href='" . base_url($child_menu_page_link) . "'>$child_icon $child_menu_page_name</span></a> ";
                                        $output .= " </li> ";
                                    } else {
                                        $i--;
                                        break;
                                    }
                                }
                                $output .= '</ul>';
                            } else {
                                
                                $output .= "</a> ";
                            }                           
                        }
                        $output .= " </li> ";
                        echo " <li$active> " . $output;
                    }

                }
                
                ?>


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
