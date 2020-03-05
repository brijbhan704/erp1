@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<link href="{{ asset('/css/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<div class="right_col" role="main">
@include('layout/flash')
  <div class="col-md-12 col-xs-12">

      <div class="x_panel">
        <div class="x_title">
          <h2>Add User</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br>
                <form class="form-horizontal form-label-left" action="{{ url('/') }}/users/create" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Name</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input type="text" name="name" id="name" class="form-control">
                    </div>
                  </div>
                             
                   
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12 control-label">Mobile</label>
                  </div>
                  <div class="form-group">                        
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input type="text" name="mobile" id="mobile" class="form-control">
                  </div>
                  </div>  
                  
                  <div class="form-group" style="float:left">
                  <label for="content" class="col-sm-12">Email</label>
                  </div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input type="emal" name="email" id="email" id="email" class="form-control">
                  </div>
                  </div>
				  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Company</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control" name="company">
                        <option value="0">--Select Company--</option>
                        @if(isset($userCompany))
                          @foreach($userCompany as $k=>$v)
                          <option value="{{$v->id}}">{{$v->companyName}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
				  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Department</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control" name="department" onchange="getUsersByDepartment(this.value)">
                        <option value="0">--Select Department--</option>
                        @if(isset($userDepartment))
                          @foreach($userDepartment as $k=>$v)
                          <option value="{{$v->id}}">{{$v->department}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
				  
				  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Role</label>
                  </div>
                  <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control" name="role">
                        <option value="0">--Select Role--</option>
                        @if(isset($userRoles))
                          @foreach($userRoles as $k=>$v)
                          <option value="{{$v->id}}">{{$v->role	}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
				  <div class="form-group" style="float:left">
                    <label for="content" class="col-sm-12 control-label">Reporting To</label>
                  </div>
				   <div class="form-group">                        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <select class="form-control" name="reporting_person_id" id="reporting_person_id">
                        <option value="0">--Select--</option>
                        
                      </select>
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/masterplans'">Cancel</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
          </div>
        </div>
    </div>
</div>

@endsection
<script>
function getUsersByDepartment(dept_id){
	$.ajax({
		url:"{{ url("/") }}/users/getUsersByDepartment",
		'headers': {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
		type:'post',
		data:{dept_id:dept_id},
		success:function(data){
			if(data.users.length>0){
				var html='<option value="0">--Select User-</option>';
				$.each(data.users,function(k,user){
					 html +='<option value="'+user.id+'">'+user.name+' ('+user.role+') </option>';
				});
				$('#reporting_person_id').html(html);
			}
		}
	})
}
</script>
