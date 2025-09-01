@extends('profile.profile-template')
@section('profile')
<style type="text/css">
  input{
    width: 100%;
    padding: 5px;
  }

  .profile-page{
    box-shadow: 1px 1 px 5px #9b9b9b;
  }
</style>

<div class="container">
      <div class="row">

      </div>
        <div class="col-md-12 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading" style="background-color: #333;">
              <h3 class="panel-title" style="color: #fff;">Profile - {{Auth::user()->username}}
              	<span class="pull-right" style="font-size: 12px;">Last Changed <br>{{$information->updated_at}}</p></span></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 profile-page" align="center"> <img alt="User Pic" src="{{ asset('/images/profile_photo/'.App\Models\Employee::where('emp_id', Auth::user()->emp_id)->value('profile_pic')) }}" class="img-square img-responsive">
                    <div class="col-md-12">
                        <form id="uploadProfilePic" action="/uploadProfilePic" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <input type="file" name="profile_photo" onclick="this.value = null" onchange="uploadPic()">
                        </form>
                    </div>
                </div>
                
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table id="profileform"  class="table table-user-information">
                    <tbody>
                      <form id="profileUpdateForm" action="/profile_update" method="POST">
                        {{csrf_field()}}
                    	<tr>
                        <td><b>First Name:</b></td>
                        <td><input type="text" id="a" name="first_name" value="{{$information->first_name}}" disabled></td>
                      </tr>
                      <tr>
                        <td><b>Surname:</b></td>
                        <td><input type="text" id="b" name="last_name" value="{{$information->last_name}}" disabled></td>
                      </tr>
                      <tr>
                        <td><b>Other Names:</b></td>
                        <td><input type="text" id="c" name="other_name" value="{{$information->other_name}}" disabled></td>
                      </tr>
                        <tr>
	                        <td><b>Gender</b></td>
	                        <td><input type="text" id="f" name="gender" value="{{$information->gender}}" disabled></td>
	                      </tr>
                        <tr>
                        <td><b>Home Address</b></td>
                        <td><textarea type="text" id="g" name="address" disabled>{{$information->address}}</textarea></td>
                      </tr>
                      <tr>
                        <td><b>Phone Number</b></td>
                        <td><input type="text" id="j" name="contact_number" value="{{$information->contact_number}}" disabled>
                        </td>
                           
                      </tr>
                     </form>
                    </tbody>
                  </table>
                  
                  
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <button id="editBtn" class="btn btn-primary"><i class="glyphicon glyphicon-edit" ></i>Edit</button>
                 </div>
            
          </div>
        </div>
      </div>
    </div>


<div id="loading_progress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; margin-top: 40px;">
        <div class="modal-dialog">
            <center>
                <img src="{{asset('images/loader.gif')}}" alt="please wait">
            </center>
        </div>

    </div><!-- /.modal -->
@endsection