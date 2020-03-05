<!-- Top navbar -->


<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('ER-PORTAL Dashboard') }}</a>
        <!-- Form -->
        <ul class="navbar-nav ml-auto">
            @if(Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="navbarDropdown" aria-haspopup="true">
                    
                    <i class="fa fa-globe"></i>Notification<span class="badge btn-danger" id="count-notification">{{ auth()->user()->unreadNotifications->count() }}</span><span class="caret"></span> 
                </a>

                <div class="dropdown-menu" area-labelledby="navbarDropdown" >
                    @if(auth()->user()->unreadNotifications->count())
                    <a class=" dropdown-item" href="#">
                    data show here
                    </a>
                    @endif
                    <a class=" dropdown-item" href="#">
                   Data Show Here
                    </a>

              </div>
            </li>
            @endif
        </ul>
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('assets/img/theme/download.png')}}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{url('/')}}/myprofile" class="dropdown-item">
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
    </div>
</nav>

<div class="modal fade" id="invoiceModal">
                <div class="modal-dialog">
                    <div class="modal-content">           
                         <form method="get" action= "/updateproduct">
                            <div class="modal-header">        
                            <h4 class="modal-title text-red">Request Order</h4>
                        </div>
                        <div class="modal-body">                         
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>PO Invoice ID</td>
                                        <td><input type="text" id="invoice"  name="invoice" class="no-outline" id="invoice"  style="width: 80%;" required/></td>
                                    </tr>
                                                                     
                                    <tr>
                                        <td></td>
                                        <td><label class="control-label"> Quantity:</label></td>
                                        <td><input onkeyup="checkValidation()"  class="no-outline" type="number" id="qtyIN" name="qty" style="width: 80%;" required/></td>
                                       
                                    </tr>

                                     <tr>
                                        <td></td>
                                        <td><label class="control-label"> Product Name:</label></td>
                                        <td><input type="text"  name="product_name" class="no-outline" id="item_name" style="width: 80%;" required/></td>
                                         <input id="ID" name="ID" type="hidden"  required/>
                                    </tr>
                                  
                                    
                                </tbody>

                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>                             
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>

                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
