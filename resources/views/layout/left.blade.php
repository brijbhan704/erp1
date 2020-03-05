<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <li><a href="{{ url('/home') }}" style="color: black !important;  "><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <!-- <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i> Manage Product <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/products">Product List</a></li>
            <li><a href="{{ url('/') }}/products/uploadcsv">Import CSV</a></li>
        </ul>
      </li> -->
    
           
      @can('user-list')
      <li><a style="color: black !important;  "><i class="fa fa-users"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users" style="color: black !important;  ">Users List</a></li> 
        </ul>
      </li> 
      @endcan

      @can('role-list')
      <li><a style="color: black !important;  "><i class="fa fa-users"></i> Manage Roles <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/roles" style="color: black !important;  ">Roles List</a></li>
        </ul>
      </li>
        @endcan 
         @can('category-list')
      <li><a style="color: black !important;  "><i class="fa fa-list-alt" aria-hidden="true"></i> Manage Category <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/category" style="color: black !important;  ">Category List</a></li>
        </ul>
      </li>
 @endcan 
 @can('expense-list')  
      <li><a style="color: black !important;  "><i class="fa fa-money" aria-hidden="true"></i> Manage Expense <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/expenses" style="color: black !important;  ">Expense List</a></li>
            <li><a href="{{ url('/') }}/approvedexpenses" style="color: black !important;  ">Approved Expenses</a></li>
            <li><a href="{{ url('/') }}/rejectexpenses" style="color: black !important;  ">Rejected Expenses</a></li>
        </ul>
      </li>
@endcan 

       <li><a style="color: black !important;  "><i class="fa fa-houzz" aria-hidden="true"></i> Manage Inventory <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/inventory" style="color: black !important;  ">Inventory List</a></li>
        </ul>
      </li>

<!-- <i class="fa fa-cog fa-spin fa-3x fa-fw"> -->
       <li><a style="color: black !important;  "><i class="fa fa-bell" aria-hidden="true"></i> Manage Notifications<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/notifications" style="color: black !important;  ">Send Notifications</a></li>
            
        </ul>
      </li>
    </ul>
  </div>

</div>
