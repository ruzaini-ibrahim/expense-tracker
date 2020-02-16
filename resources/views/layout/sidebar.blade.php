<div class="site-menubar">
    <ul class="site-menu">
      <li class="site-menu-item {{Request::is('home') ? 'active' : ''}}">
        <a href="{{ url('/home') }}">
          <i class="site-menu-icon blue-400 wb-dashboard" aria-hidden="true" ></i>
          <span class="site-menu-title">Dashboard</span>
          <span class="site-menu-arrow"></span>
        </a>        
      </li>
      <li class="site-menu-item {{Request::is('expense') ? 'open active' : ''}}">
        <a href="{{ url('/expense') }}">
          <i class="site-menu-icon blue-400 wb-envelope-open" aria-hidden="true" ></i>
          <span class="site-menu-title">Expense</span>
          <span class="site-menu-arrow"></span>
        </a>        
      </li>
      <li class="site-menu-item">
        <a href="{{ url('/custom') }}">
          <i class="site-menu-icon blue-400 wb-book" aria-hidden="true" ></i>
          <span class="site-menu-title">Customization</span>
          <span class="site-menu-arrow"></span>
        </a>        
      </li>
      <li class="site-menu-item has-sub {{Request::is('user_management/*') ? 'active' : ''}}">
        <a href="javascript:void(0)">
          <i class="site-menu-icon blue-400 wb-users" aria-hidden="true" ></i>
          <span class="site-menu-title">User Management</span>
          <span class="site-menu-arrow"></span>
        </a>
        <ul class="site-menu-sub">
            <li class="site-menu-item {{Request::is('admin/4') ? 'active' : ''}}">
                <a class="animsition-link" href="{{url('admin/user_management/admin')}}">
                    <span class="site-menu-title">User Administrator</span>
                </a>
            </li>
            <!-- <li class="site-menu-item {{Request::is('admin/user_management/role/roles') ? 'active' : ''}}">
                <a class="animsition-link" href="{{url('admin/user_management/role/roles')}}">
                    <span class="site-menu-title">Roles</span>
                </a>
            </li> -->
            <li class="site-menu-item {{Request::is('admin/user_management/role') ? 'active' : ''}}">
                <a class="animsition-link" href="{{url('admin/user_management/role')}}">
                    <span class="site-menu-title">Roles</span>
                </a>
            </li>
            <!-- <li class="site-menu-item {{Request::is('admin/user_management/permission/permissions') ? 'active' : ''}}">
                <a class="animsition-link" href="{{url('admin/user_management/permission/permissions')}}">
                    <span class="site-menu-title">Permissions</span>
                </a>
            </li> -->
            <li class="site-menu-item {{Request::is('user_management/permission') ? 'active' : ''}}">
                <a class="animsition-link" href="{{url('user_management/permission')}}">
                    <span class="site-menu-title">Permissions</span>
                </a>
            </li>
        </ul>     
      </li>
    </ul>
  </div>