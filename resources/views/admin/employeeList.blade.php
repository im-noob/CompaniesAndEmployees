@extends('layouts.app')

@section('Listcontent')
    {{-- START:Showing Success Message --}}
    <div id="status">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif             
    </div>
        
    {{-- END:Showing Success Message --}}

    <section>
        <table class="table table-hover table-triped">
            <thead>
                <tr>
                    <th scope="col">UserID</th>
                    <th scope="col">FName</th>
                    <th scope="col">LName</th>
                    <th scope="col">Email</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">phone</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>

            <tbody>

              @forelse ($data as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <th>{{$item->fname}}</th>
                    <th>{{$item->lname}}</th>
                    <th>{{$item->email}} </th>
                    <th>{{$item->companyName}}</th>
                    <th>{{$item->phone}}</th>
                    {{-- START:Update Button --}}
                    <th>
                      <button type="button"  class="btn btn-primary update_btn update_button" data-toggle="modal" data-target="#Update_Employee_Button_Modal_{{$item->id}}">Update</button>
                          

        {{-- UpdateNew Employee Button Modal Section:START --}}
        <div class="modal fade" id="Update_Employee_Button_Modal_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="Update_Employee_Button_Modal_Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Update_Employee_Button_Modal_Label">Update Employee</h5>
                        <button id="UpdateEmployeeCloseButton_{{$item->id}}" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="UpdateEmployeeFormError_{{$item->id}}">
                            
                        </div>
                        <form method="POST" action="{{ url('employees') }}" id="UpdateEmployeeForm">
                            @csrf

                            <div class="form-group row">
                                <label for="Empfname_{{$item->id}}" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                                <div class="col-md-6">
                                    <input id="Empfname_{{$item->id}}" type="text" class="form-control" name="fname" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Emplname_{{$item->id}}" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                <div class="col-md-6">
                                    <input id="Emplname_{{$item->id}}" type="text" class="form-control" name="lname" required autofocus>
                                </div>
                            </div>
                                            
                            
    
                            <div class="form-group row">
                                <label for="Empemail_{{$item->id}}" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="Empemail_{{$item->id}}" type="text" class="form-control" name="email" required>
                                </div>
                            </div>
    
                            
    
                            <div class="form-group row">
                                <label for="Empphone_{{$item->id}}" class="col-md-4 col-form-label text-md-right">{{ __('phone') }}</label>
                                <div class="col-md-6">
                                    <input id="Empphone_{{$item->id}}" type="text" class="form-control" name="phone"  required>
                                </div>
                            </div>
    
    
  

                            <div class="form-group row">
                                <label for="Company_id{{$item->id}}" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>
                                <div class="col-md-6">
                                  <select class="form-control" id="Company_id{{$item->id}}" name="company_id">
                                      @forelse ($companyList as $company)
                                          <option value="{{$company->id}}">{{$company->name}}</option>
                                      @empty
                                          <option value="0">No Company</option>
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
            
            
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" Emp_ID="{{$item->id}}" id="UpdateEmployeeButton" class="UpdateEmployeeButton btn btn-primary" >
                                        Update Employee
                                    </button>
                                </div>
                            </div>
    
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
        {{-- UpdateNew Employee Button Modal Section:STOP --}}
    
                    </th>
                    {{-- STOP:Update Button --}}

                    {{-- START:Delete Button --}}
                    <th>
                        <form method="POST" action="{{url('/employees')}}/{{$item->id}}"> 
                          @method("DELETE")
                          @csrf
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </th>
                    {{-- STOP:Delete Button --}}

                </tr>
              @empty
                  <tr>
                    <th colspan="6" style="text-align: center;"><h1>No Data Found</h1></th>
                  </tr>
              @endforelse
                

              
                


            </tbody>

        </table>
        <div style="width: 100%;">
            <div class="text-xs-center">
                    {{ $data->links() }}
            </div>
        </div>

        <script>
            $(function(){
                //centring paginating button

                try {
                    document.getElementsByClassName("pagination")[0].classList.add("justify-content-center");
                    
                } catch (error) {
                    console.log("Less than 10 data");
                }

            })
        </script>
        
    </section>

    <script>
        $(function(){
            console.log("loaded");

            //Update Employee Section:START
            $(".UpdateEmployeeButton").click(function(){


                console.log("UpdateEmployeeButton");
                $id = $(this).attr("Emp_ID");
                $Empfname = $("#Empfname_"+$id).val();
                $Emplname = $("#Emplname_"+$id).val();
                $Empemail = $("#Empemail_"+$id).val();
                $Empphone = $("#Empphone_"+$id).val();
                $company_id = $("#Company_id"+$id).val();

                console.log($id);
                if(!validateEmail($Empemail)){
                    alert("Not a valid Email");
                    return;
                }

                
                
                // START: Ajax Request
                $.ajax({
                            cache: false,
                            type: "POST",
                            data: {
            
                                _method: "PUT",
                                _token:  "{{ csrf_token() }}",
                                fname : $Empfname,
                                lname : $Emplname,
                                email : $Empemail,
                                phone : $Empphone,
                                company_id : $company_id,
                            },
                            url: "{{url('/')}}/employees/"+$id, 
                            success: function(response){
                                console.log(response)
                                if (response.received) {

                                    $("#UpdateEmployeeCloseButton_"+$id).click();
                                    $("#status").text("");
                                    $("#status").append('<div class="alert alert-success" role="alert">'+
                                            response.message
                                        +'</div>');

                                    //clearing data on success
                                    $("#Empfname_"+$id).val("");
                                    $("#Emplname_"+$id).val("");
                                    $("#Empemail_"+$id).val("");
                                    $("#Empphone_"+$id).val("");
                                    $("#Company_id"+$id).val("");

                                    //refreshing list
                                    setTimeout(function(){
                                        location.reload();
                                    },2000);

                                    

                                }else{
                                    alert("Oops!!! Somthing is not right");
                                }
                            },
                            error: function(xhr,status,error){
                                $("#UpdateEmployeeFormError_"+$id).text("");
                                $.each(xhr.responseJSON.errors, function (indexInArray, valueOfElement) { 
                                    console.log(valueOfElement[0]);
                                     $("#UpdateEmployeeFormError_"+$id).append('<div class="alert alert-danger" role="alert">'+
                                            valueOfElement[0]
                                        +'</div>');
                                });

                                console.log(xhr.responseJSON);

                                console.log(status);
                                console.log(error);
                            }
                    });
                    // END: Ajax Request
            })
            //Update Employee Section:STOP

        })
    </script>

@endsection
