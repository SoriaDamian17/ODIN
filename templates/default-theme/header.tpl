<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="templates/{$theme}/images/favicon.ico">

        <!-- App title -->
        <title>Uplon - Responsive Admin Dashboard Template</title>

        <!-- Switchery css -->
        <link href="templates/{$theme}/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!--Form Wizard-->
       <link rel="stylesheet" type="text/css" href="templates/{$theme}/plugins/jquery.steps/demo/css/jquery.steps.css" />

       <!-- Plugins css-->
        <link href="templates/{$theme}/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="templates/{$theme}/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
        <link href="templates/{$theme}/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
       <link href="templates/{$theme}/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
       <link href="templates/{$theme}/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
       <!-- Responsive datatable examples -->
       <link href="templates/{$theme}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert css -->
        <link href="templates/{$theme}/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        {if $nameController != 'AdminLogin'}
        <link href="templates/{$theme}/css/style.css" rel="stylesheet" type="text/css" />        
        {else}
        <link id="base-style" href="templates/{$theme}/css/admin-theme.css" rel="stylesheet" />
        <link id="base-style" href="templates/{$theme}/css/style-responsive.css" rel="stylesheet" />        
        {/if}


       
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Modernizr js -->
        <script src="templates/{$theme}/js/modernizr.min.js"></script>
    </head>


<body>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div id="wrapper" class="{if $nameController != 'AdminLogin'}wrapper{else}container-fluid-full{/if}">
      <div class="{if $nameController != 'AdminLogin'}container{else}row-fluid bootstrap{/if}">
