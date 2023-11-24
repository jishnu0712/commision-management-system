<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
       <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent"
          data-toggle="push-menu" role="button">
       <i data-feather="menu"></i>
       </a>
       <!-- Logo -->
       <a href="/" class="logo p-0">
          <!-- logo-->
          <div class="logo-lg">
             <span class="light-logo"><img src="{{ asset('assets/images/fnlogo.png') }}" width="180"
                alt="logo"></span>
             <span class="dark-logo"><img src="{{ asset('assets/images/fnlogo.png') }}" width="180"
                alt="logo"></span>
          </div>
       </a>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
       <!-- Sidebar toggle button-->
       <div class="app-menu">
          <ul class="header-megamenu nav">
             <li class="btn-group nav-item d-md-none">
                <a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu"
                   role="button">
                <i data-feather="menu"></i>
                </a>
             </li>
          </ul>
       </div>
       <div class="navbar-custom-menu r-side">
          <ul class="nav navbar-nav">
             <li class="btn-group nav-item d-lg-flex d-none align-items-center">
                <p class="mb-0 text-fade pr-10 pt-5"><?php echo date('l, jS F Y'); ?></p>
             </li>
             <li class="btn-group nav-item d-lg-inline-flex d-none">
                <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen"
                   title="Full Screen">
                <i data-feather="maximize"></i>
                </a>
             </li>
             <!-- User Account-->
             <li class="dropdown user user-menu">
                <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
                   title="User">
                <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                </a>
                <ul class="dropdown-menu animated flipInX">
                   <li class="user-body">
                      <a class="dropdown-item " href="{{ Route::has('profile.index') ? route('profile.index') : '/profile' }}"><i
                         class="ti-user text-muted mr-2"></i> Profile</a>
                         
                      <a class="dropdown-item" href="/password"><i class="ti-wallet text-muted mr-2"></i> Change
                      Password</a>
                      <a class="dropdown-item" href="/settings"><i class="ti-settings text-muted mr-2"></i>
                      Settings</a>
                      <a class="dropdown-item" target="_blank"
                         href="javascript:void(0);"><i
                         class="ti-help text-muted mr-2"></i> Help</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="/logout"><i
                         class="ti-lock text-muted mr-2 text-danger"></i>
                      Logout</a>
                   </li>
                </ul>
             </li>
          </ul>
       </div>
    </nav>
 </header>
 <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
       <div class="user-profile px-20 pt-15 pb-10">
          <div class="d-flex align-items-center">
             <div class="image">
                <img src="{{ asset('storage/profile_pic/' . auth()->user()->profile_pic) }}"
                   class="avatar avatar-lg bg-primary-light rounded100" alt="User Image">
             </div>
             <div class="info">
                <a class="px-20" href="#">
                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                </a>
             </div>
          </div>
          <ul class="list-inline profile-setting mt-20 mb-0 d-flex justify-content-between">
             <li><a href="#" data-toggle="tooltip" data-placement="top" title="Search"><i
                data-feather="search"></i></a></li>
             <li><a href="#" data-toggle="tooltip" data-placement="top" title="Notification"><i
                data-feather="bell"></i></a></li>
             <li><a href="#" data-toggle="tooltip" data-placement="top" title="Chat"><i
                data-feather="message-square"></i></a></li>
             <li><a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="top"
                title="Logout"><i data-feather="log-out"></i></a></li>
          </ul>
       </div>
       <!-- sidebar menu-->
       <ul class="sidebar-menu" style="overflow-y: scroll !important; height: 70vh !important;" data-widget="tree">
          <li>
             <a href="{{ route('dashboard.index') }}">
             <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
             <span>Dashboard</span>
             </a>
          </li>
          <li class="treeview">
             <a href="#">
             <i class="icon-Thunder-move"><span class="path1"></span><span class="path2"></span></i>
             <span>Users</span>
             <span class="pull-right-container">
             <i class="fa fa-angle-right pull-right"></i>
             </span>
             </a>
             <ul class="treeview-menu">
                <li><a href="{{ route('user.create') }}"><i class="icon-Commit"><span class="path1"></span><span
                   class="path2"></span></i>All Users</a></li>
                <li><a href="{{ route('user.create') }}"><i class="icon-Commit"><span class="path1"></span><span
                   class="path2"></span></i>Add User</a></li>
             </ul>
          </li>
       </ul>
       
    </section>
 </aside>
 <!-- Content Wrapper. Contains page content -->