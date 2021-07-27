<section id="mainHeader">
   <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="#"><img src="{{asset('assets/img/logo.png')}}" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
               <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/about">About Us</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="/contact">Contact</a>
            </li>
            @auth
            <li class="nav-item">
                  <div class="dropdown">
                     <button class="dropbtn"><i class="fa fa-user-circle-o" aria-hidden="true"></i></button>
                     <div class="dropdown-content">
                        <h3>Mena Insurance</h3>
                        <p>Customer # <span><b>025894</b></span></p>
                        <a href="/subscription#">My Subscription</a>
                        <a href="/account"><i class="fa fa-user" aria-hidden="true"></i> Account Setting</a>
                        <a href="/history"><i class="fa fa-history" aria-hidden="true"></i> Renewal & Billing History</a>
{{--                         <a class="menu-link px-5" href="{{ route('logout') }}"--}}
{{--                            onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                             {{ __('Logout') }}--}}
{{--                         </a>--}}

{{--                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                             @csrf--}}
{{--                         </form>--}}

                         <p class="logout">
                             <a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                 <i class="fa fa-sign-out" aria-hidden="true"></i>
                                 Logout
                             </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                             @csrf
                         </form>
                         </p>
                     </div>
                  </div>
            </li>
            @endauth


         </ul>
         @guest
         <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
               <a class="nav-link" href="{{route('login')}}">Log in</a>
            </li>
            <li class="nav-item">
               <a class="nav-link registerBtn" href="{{route('register')}}">Register</a>
            </li>
         </ul>
         @endguest
      </div>
   </nav>
</section>