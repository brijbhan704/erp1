

<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="navbar-left"> <h2 class="brand brand-name navbar-left" style="font-size: 24px;"><b>EnterPrise Resource Portal</h2>
        </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="user">
          <h2><a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >

            @if (Auth::user()->name)
                {{  Auth::user()->name }}
            @endif
            <span class=" fa fa-user" style=" border: 1px solid #337ab7;;
    padding: 5px 6px;
    border-radius: 50%; font-size: 20px;"></span>
          </a></h2>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li class="hide"><a href="javascript:;"> Profile</a></li>
            <li class="hide">
              <a href="javascript:;">
                <span class="badge bg-red pull-right">50%</span>
                <span>Settings</span>
              </a>
            </li>
            <li class="hide"><a href="javascript:;">Help</a></li>
            <li>
              <li>
                  <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
              </li>
              <li>
                <a href="/users/changepass">
                      Change Password
                </a>
              </li>
          </ul>
        </li>

        <li role="presentation" class="dropdown">
          
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            <li class="hide">
              <a>
                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                <span>
                  <span>John Smith</span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                  News wire notification
                </span>
              </a>
            </li>

            

          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>

