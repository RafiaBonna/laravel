<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
  <style>

    /* Navbar background primary color & text white */
  .main-header.navbar {
      background-color: #007bff !important; /* Primary color */
      color: #ffffff !important;            /* Text white */
  }

  /* Navbar links & icons white */
  .main-header .nav-link, 
  .main-header .navbar-nav .nav-item .nav-link i,
  .main-header .navbar-nav .nav-item .badge {
      color: #ffffff !important;
  }

  /* Navbar search input background & text */
  .main-header .form-control-navbar {
      background-color: rgba(255, 255, 255, 0.2) !important;
      color: #ffffff !important;
  }

  /* Navbar search button icon white */
  .main-header .btn-navbar i {
      color: #ffffff !important;
  }
    /* Sidebar-er Background Color */
    .main-sidebar, .sidebar-dark .nav-sidebar > .nav-item > .nav-link.active, .sidebar-dark .nav-sidebar > .nav-item:hover > .nav-link {
      background-color: #2dbde093 !important; 
    }

  
    .main-sidebar .nav-link, .main-sidebar .user-panel > .info > a, .main-sidebar .brand-text, .main-sidebar .brand-link .image, .main-sidebar .nav-icon {
      color: #FFFFFF !important;
    }
    
    /* Search input box-er background transparent ebong text white korar jonne */
    .sidebar-search .form-control-sidebar {
        background-color: transparent !important;
        color: #FFFFFF !important;
    }

    /* Sidebar-er brand link-er bottom border-ti halka kore dilam */
    .brand-link {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
  </style>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">