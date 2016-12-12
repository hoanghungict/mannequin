<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! \URLHelper::asset('libs/adminlte/img/user2-160x160.jpg','admin') !!}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed
                            Sidebar</a></li>
                </ul>
            </li>

            <li @if( $menu=='dashboard') class="active" @endif ><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li @if( $menu=='admin_users') class="active" @endif ><a href="{!! URL::action('Admin\AdminUserController@index') !!}"><i class="fa fa-user-secret"></i> <span>Admin Users</span></a></li>
            <li @if( $menu=='users') class="active" @endif ><a href="{!! URL::action('Admin\UserController@index') !!}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li @if( $menu=='site_configurations') class="active" @endif ><a href="{!! URL::action('Admin\SiteConfigurationController@index') !!}"><i class="fa fa-cogs"></i> <span>Site Configurations</span></a></li>
            <li @if( $menu=='article') class="active" @endif ><a href="{!! URL::action('Admin\ArticleController@index') !!}"><i class="fa fa-file-word-o"></i> <span>Articles</span></a></li>
            <li @if( $menu=='user_notification') class="active" @endif ><a href="{!! URL::action('Admin\UserNotificationController@index') !!}"><i class="fa fa-bell"></i> <span>UserNotifications</span></a></li>
            <li @if( $menu=='admin_user_notification') class="active" @endif ><a href="{!! URL::action('Admin\AdminUserNotificationController@index') !!}"><i class="fa fa-bell-o"></i> <span>AdminUserNotifications</span></a></li>
            <li @if( $menu=='image') class="active" @endif ><a href="{!! URL::action('Admin\ImageController@index') !!}"><i class="fa fa-file-image-o"></i> <span>Images</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>