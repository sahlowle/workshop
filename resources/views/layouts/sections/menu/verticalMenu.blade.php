<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo mb-4">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img id="app_logo" src="{{ asset('assets/img/logo.png') }}" style="max-height: 45px">
        {{-- @include('_partials.macros',["width"=>25,"withbg"=>'#696cff']) --}}
      </span>
    </a>
    

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    
    <li @class(['menu-item', 'active' => (request()->routeIs('home') || request()->routeIs('index')) ])>
      <a href="{{ route('home') }}" class="menu-link" >
        
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        
        <div> @lang('Home') </div>
      </a>      
    </li>

    <li @class(['menu-item', 'active' => request()->routeIs('customers*') ])>
      <a href="{{ route('customers.index') }}" class="menu-link" >
        
        <i class='menu-icon bx bx-happy'></i>
        
        <div> @lang('Customers') </div>
      </a>      
    </li>

    <li @class(['menu-item', 'active open' => request()->routeIs('orders*') ]) >
      <a href="javascript:void(0);" class="menu-link menu-toggle" >
       
        <i class='menu-icon bx bxs-calendar-check'></i>
        
        <div> @lang('Orders') </div>
      </a>

      <ul class="menu-sub">
        <li @class(['menu-item', 'active' => request()->routeIs('orders.today') ])>
          <a href="{{ route('orders.today') }}" class="menu-link" >            
            <div> @lang('Today Orders') </div>
          </a> 
        </li>
        
        <li @class(['menu-item', 'active' => request()->routeIs('orders.index') ])>
          <a href="{{ route('orders.index') }}" class="menu-link" >            
            <div> @lang('All Orders') </div>
          </a> 
        </li>

        @php
            $unpaidOrder = \App\Models\Order::unpaid()->has('activeCustomer')->count();
        @endphp

        <li @class(['menu-item', 'active' => request()->routeIs('orders.unpaid') ])>
          <a href="{{ route('orders.unpaid') }}" class="menu-link" >            
            <div> 
              @lang('Payment alert')
              <span class="badge rounded-pill bg-warning text-dark"> {{ $unpaidOrder }} </span>
            </div>
          </a> 
        </li>
      </ul>

    </li>

    <li @class(['menu-item', 'active open' => request()->routeIs('roads*') ]) >
      <a href="javascript:void(0);" class="menu-link menu-toggle" >
       
        <div> 
          <i class='menu-icon bx bx-map-alt'></i>
          @lang('Routes')
        </div>
      </a>

      <ul class="menu-sub">
        <li @class(['menu-item', 'active' => request()->routeIs('roads.today') ])>
          <a href="{{ route('roads.today') }}" class="menu-link" >            
            <div> @lang('Today Routes') </div>
          </a> 
        </li>
        
        <li @class(['menu-item', 'active' => request()->routeIs('roads.index') ])>
          <a href="{{ route('roads.index') }}" class="menu-link" >            
            <div> @lang('All Routes') </div>
          </a> 
        </li>
      </ul>

    </li>
    
    

   
{{-- 
    <li @class(['menu-item', 'active' => request()->routeIs('orders*') ])>
      <a href="{{ route('orders.index') }}" class="menu-link" >
        
        <i class='menu-icon bx bxs-calendar-check'></i>
        
        <div> @lang('Orders') </div>
      </a>      
    </li> --}}

    

    <li @class(['menu-item', 'active' => request()->routeIs('drivers*') ])>
      <a href="{{ route('drivers.index') }}" class="menu-link" >
        
        <i class='menu-icon bx bx-wrench'></i>
        
        <div> @lang('Technician') </div>
      </a>      
    </li>

    <li @class(['menu-item', 'active' => request()->routeIs('users*') ]) >
      <a href="{{ route('users.index') }}" class="menu-link" >
        
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        
        <div> @lang('Admins') </div>
      </a>      
    </li>
  

    
    
  </ul>

</aside>


    <script>
          var state = "expanded";

          function collapseSideBar() {
            if (state == "expanded") {
              $('.layout-menu').css({maxWidth: "4rem"});
              $('.layout-page').css({paddingLeft: "2rem"});

              $("#app_logo").attr("src","{{ asset('small-logo.jpg') }}");
              $(".app-brand").css({"padding-left": "1rem"});
              state = "minimized";
            } else {
              if (state == "minimized") {
                $('.layout-menu').removeAttr("style");
                $('.layout-page').removeAttr("style");
                $("#app_logo").attr("src","{{ asset('assets/img/logo.png') }}");
                $(".app-brand").css({"padding-left": "2rem"});
                state = "expanded";
              }
            }

          }
    </script>
