<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/logo.png') }}" style="max-height: 55px">
        {{-- @include('_partials.macros',["width"=>25,"withbg"=>'#696cff']) --}}
      </span>
      {{-- <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span> --}}
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    
    <li @class(['menu-item', 'active' => request()->routeIs('home') ])>
      <a href="{{ route('home') }}" class="menu-link" >
        
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        
        <div> @lang('Home') </div>
      </a>      
    </li>

    <li @class(['menu-item', 'active' => request()->routeIs('users*') ])>
      <a href="{{ route('users.index') }}" class="menu-link" >
        
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        
        <div> @lang('Users') </div>
      </a>      
    </li>
  
    {{-- <li @class(['menu-item menu-toggle', 'active' => request()->is('/k') ])>
      <a href="{{ route('home') }}" class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
        
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        @endif
        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
      </a>
    </li> --}}
    
    
  </ul>

</aside>
