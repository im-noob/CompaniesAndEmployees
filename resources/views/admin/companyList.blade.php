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
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Website</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>

            <tbody>

              @forelse ($data as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <th> {{$item->name}}</th>
                    <th>{{$item->email}} </th>
                    <th>
                        @if ($item->logo!= "")
                            <img style="height: 50px;" src="{{asset('storage/'.$item->logo)}}" class ="img-thumbnail"/>
                        @endif
                    </th>
                    <th>{{$item->website}}</th>
                    {{-- START:Update Button --}}
                    <th>
                      <button type="button"  class="btn btn-primary update_btn update_button" data-toggle="modal" data-target="#Update_Company_Button_Modal_{{$item->id}}">Update</button>
                          

        {{-- UpdateNew Company Button Modal Section:START --}}
        <div class="modal fade" id="Update_Company_Button_Modal_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="Update_Company_Button_Modal_Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Update_Company_Button_Modal_Label">Update Company</h5>
                        <button id="UpdateCompanyCloseButton_{{$item->id}}" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="UpdateCompanyFormError_{{$item->id}}">
                            
                        </div>
                        <form method="POST" action="{{ url('employees') }}" id="UpdateEmployeeForm">
                            @csrf
                            @method("PUT")
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="Compname_{{$item->id}}" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>
                                            
                            
    
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="Compemail_{{$item->id}}" type="text" class="form-control" name="email" required>
                                </div>
                            </div>
    
                            
    
                            <div class="form-group row">
                                <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('website') }}</label>
                                <div class="col-md-6">
                                    <input id="Compwebsite_{{$item->id}}" type="text" class="form-control" name="website"  required>
                                </div>
                            </div>
    
{{--     
                            <div class="form-group row">
                                <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('logo') }}</label>
                                <div class="col-md-6">
                                    <input id="Complogo_{{$item->id}}" type="file" class="form-control" name="logo" accept="image/*">
                                </div>
                            </div> --}}
            
            
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" Compname_ID="{{$item->id}}" id="UpdateCompanyButton" class="UpdateCompanyButton btn btn-primary" >
                                        Update Company
                                    </button>
                                </div>
                            </div>
    
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
        {{-- UpdateNew Company Button Modal Section:STOP --}}
    
                    </th>
                    {{-- STOP:Update Button --}}

                    {{-- START:Delete Button --}}
                    <th>
                        <form method="POST" action="{{url('/companies')}}/{{$item->id}}"> 
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
                document.getElementsByClassName("pagination")[0].classList.add("justify-content-center");

            })
        </script>
        
    </section>

    <script>
        $(function(){
            console.log("loaded");

            //Update Company Section:START
            $(".UpdateCompanyButton").click(function(){


                console.log("UpdateCompanyButton");
                $id = $(this).attr("Compname_ID");
                $Compname = $("#Compname_"+$id).val();
                $Compemail = $("#Compemail_"+$id).val();
                $Compwebsite = $("#Compwebsite_"+$id).val();

                if(!validateEmail($Compemail)){
                    alert("Not a valid Email");
                    return;
                }

                

                console.log($id);
                
                // START: Ajax Request
                $.ajax({
                            cache: false,
                            type: "POST",
                            data: {
            
                                _method: "PUT",
                                _token:  "{{ csrf_token() }}",
                                name : $Compname,
                                email : $Compemail,
                                website : $Compwebsite,
                            },
                            url: "{{url('/')}}/companies/"+$id, 
                            success: function(response){
                                console.log(response)
                                if (response.received) {

                                    $("#UpdateCompanyCloseButton_"+$id).click();
                                    $("#status").text("");
                                    $("#status").append('<div class="alert alert-success" role="alert">'+
                                            response.message
                                        +'</div>');

                                    //clearing data on success
                                    $("#Compname_"+$id).val("");
                                    $("#Compemail_"+$id).val("");
                                    $("#Compwebsite_"+$id).val("");

                                    //refreshing list
                                    setTimeout(function(){
                                        location.reload();
                                    },2000);

                                    

                                }else{
                                    alert("Oops!!! Somthing is not right");
                                }
                            },
                            error: function(xhr,status,error){
                                $("#UpdateCompanyFormError_"+$id).text("");
                                $.each(xhr.responseJSON.errors, function (indexInArray, valueOfElement) { 
                                    console.log(valueOfElement[0]);
                                     $("#UpdateCompanyFormError_"+$id).append('<div class="alert alert-danger" role="alert">'+
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
            //Update COmpany Section:STOP

        })
    </script>

@endsection
