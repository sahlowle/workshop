<ul class="menu-sub">
  
  <li @class(['menu-item', 'active' => request()->is('/') ])>
    <a href="{{ route('home') }}" class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
      
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      @endif
      <div> @lang('home') </div>
    </a>

    {{-- submenu --}}

    {{-- @if (isset($submenu->submenu))
    @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
    @endif --}}
    
  </li>

  <li @class(['menu-item menu-toggle', 'active' => request()->is('/k') ])>
    <a href="{{ route('home') }}" class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
      
      <i class="menu-icon tf-icons bx bx-home-circle"></i>
      @endif
      <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
    </a>
  </li>

    
</ul>
