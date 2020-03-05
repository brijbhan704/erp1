<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <!-- <img src="{{ asset('assets/img/brand/erp4.jpg')}}" style="width: 100px; height: 184px;"  class="navbar-brand-img" alt="..."> -->
            <i class="fa fa-bank" style="font-size:40px;color:blue"></i><span class="" style="margin-left: 20px; font-size: 40px;margin-left: 11px;
    font-size: 25px;
    color: indigo;
    font-weight: 600;">ER-PORTAL</span>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-1-800x800.jpg')}}">
                        </span>
                    </div> -->
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                  
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <!-- <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/brand/blue.png')}}">
                        </a>
                    </div> -->
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="demo9" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-danger"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                 @can('user-list')
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="ni ni-single-02 text-mute"></i>
                        <span class="nav-link-text" id="changeRed">{{ __('Manage Users') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" id="demo8" href="{{ url('/') }}/profile">
                                    {{ __('User profile') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="demo7" href="{{ url('/') }}/users">
                                    {{ __('User Management') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                 @endcan

                @can('role-list')

                <li class="nav-item">
                    <a class="nav-link" id="demo6" href="{{ url('/') }}/roles">
                        <i class="ni ni-user-run text-blue"></i> {{ __('Manage Roles') }}
                    </a>
                </li>
                @endcan
                @can('category-list')
                <li class="nav-item">
                    <a class="nav-link" id="demo5" href="{{ url('/') }}/category">
                        <i class="ni ni-calendar-grid-58 text-orange"></i> {{ __('Manage Category') }}
                    </a>
                </li>
                @endcan 
                @can('expense-list')
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-example" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-example">
                        <i class="fa fa-inr" style="color: #f4645f;"></i>
                        <span class="nav-link-text" id="demo10" >{{ __('Manage Expenses') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-example">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" id="demo4" href="{{ url('/') }}/expenses">
                                    {{ __('Pending Expenses List') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="demo3" href="{{ url('/') }}/approvedexpenses">
                                    {{ __('Approved Expenses List') }}
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" id="demo2" href="{{ url('/') }}/rejectexpenses">
                                    {{ __('Rejected Expenses List') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                 @endcan 

                 <li class="nav-item">
                    <a class="nav-link" href="#navbar-inventory" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-clone text-success" style="color: #f4645f;"></i>
                        <span class="nav-link-text" id="demo14" >{{ __('Manage Inventory') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-inventory">
                        <ul class="nav nav-sm flex-column">
                          <li class="nav-item">
                          <a class="nav-link" id="demo1" href="{{ url('/') }}/inventory">
                           {{ __('Inventory Management') }}
                        </a>
                        </li>
                        <l  i class="nav-item">
                            <a class="nav-link" id="demo15" href="{{ url('/') }}/showdetails">
                                {{ __('Show Details') }}
                            </a>
                        </li>                          
                        </ul>
                    </div>
                </li>
                

                <li class="nav-item">
                    <a class="nav-link" id="demo" href="{{ url('/') }}/notifications">
                        <i class="ni ni-bell-55 text-info" ></i> {{ __('Manage Notifications') }}
                    </a>
                </li>

                 @can('expense-list')           
                <li class="nav-item">
                    <a class="nav-link" id="demo11" href="{{ route('requestproduct.index') }}">
                        <i class="fa fa-shopping-cart text-danger" style="color: #f4645f;" ></i> {{ __('Manage Request Orders') }}
                    </a>
                </li>
                 @endcan 

                  @can('expense-list')           
                <li class="nav-item">
                    <a class="nav-link" id="demo12" href="{{ route('addproduct.index') }}">
                        <i class="fa fa-unlink" style="color: #f4645f;" ></i> {{ __('Manage PO') }}
                    </a>
                </li>
                 @endcan 
                 
            </ul>
            
                           <!--  <li><a href="{{URL::to('/')}}"><i class="fa fa-clone"></i> Add stock</a></li>
                            <li><a href="{{URL::to('/')}}"><i class="fa fa-leaf"></i> Manage stock</a></li>
                       
             -->
            <script type="text/javascript">
            /*document.getElementById("changeRed").onclick = function(){
            document.getElementById("changeRed").style.color = 'red';
                }*/
                $(document).ready(function(){
                  $("#changeRed").mouseover(function(){
                    $("#changeRed").css("color", "red");
                  });
                  $("#changeRed").mouseout(function(){
                    $("#changeRed").css("color", "black");
                  });
                });
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo").mouseover(function(){
                    $("#demo").css("color", "red");
                  });
                  $("#demo").mouseout(function(){
                    $("#demo").css("color", "black");
                  });
                });
           
            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo1").mouseover(function(){
                    $("#demo1").css("color", "red");
                  });
                  $("#demo1").mouseout(function(){
                    $("#demo1").css("color", "black");
                  });
                });
           
            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo2").mouseover(function(){
                    $("#demo2").css("color", "red");
                  });
                  $("#demo2").mouseout(function(){
                    $("#demo2").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo3").mouseover(function(){
                    $("#demo3").css("color", "red");
                  });
                  $("#demo3").mouseout(function(){
                    $("#demo3").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo4").mouseover(function(){
                    $("#demo4").css("color", "red");
                  });
                  $("#demo4").mouseout(function(){
                    $("#demo4").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo5").mouseover(function(){
                    $("#demo5").css("color", "red");
                  });
                  $("#demo5").mouseout(function(){
                    $("#demo5").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo6").mouseover(function(){
                    $("#demo6").css("color", "red");
                  });
                  $("#demo6").mouseout(function(){
                    $("#demo6").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo7").mouseover(function(){
                    $("#demo7").css("color", "red");
                  });
                  $("#demo7").mouseout(function(){
                    $("#demo7").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo8").mouseover(function(){
                    $("#demo8").css("color", "red");
                  });
                  $("#demo8").mouseout(function(){
                    $("#demo8").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo9").mouseover(function(){
                    $("#demo9").css("color", "red");
                  });
                  $("#demo9").mouseout(function(){
                    $("#demo9").css("color", "black");
                  });
                });            
            </script>
             <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo10").mouseover(function(){
                    $("#demo10").css("color", "red");
                  });
                  $("#demo10").mouseout(function(){
                    $("#demo10").css("color", "black");
                  });
                });            
            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo11").mouseover(function(){
                    $("#demo11").css("color", "red");
                  });
                  $("#demo11").mouseout(function(){
                    $("#demo11").css("color", "black");
                  });
                });       
            </script>

            <script type="text/javascript">
                 $(document).ready(function(){
                  $("#demo12").mouseover(function(){
                    $("#demo12").css("color", "red");
                  });
                  $("#demo12").mouseout(function(){
                    $("#demo12").css("color", "black");
                  });
                }); 

                $(document).ready(function(){
                  $("#demo14").mouseover(function(){
                    $("#demo14").css("color", "red");
                  });
                  $("#demo14").mouseout(function(){
                    $("#demo14").css("color", "black");
                  });
                }); 
                $(document).ready(function(){
                  $("#demo15").mouseover(function(){
                    $("#demo15").css("color", "red");
                  });
                  $("#demo15").mouseout(function(){
                    $("#demo15").css("color", "black");
                  });
                });       
            </script>


            
            <!-- Divider -->
           
            <!-- Heading -->
           
            <!-- Navigation -->
            <!-- <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul> -->
        </div>
    </div>
</nav>
