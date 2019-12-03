<!--<!DOCTYPE html>
<html>
    <head>
        <title>Hi</title>
    </head>
    <body>
    <h1>Welcome</h1>
    <p>Lorem jkdjhoifnlknvoinlfdvkin f;vkn oifnv;lk iufj vmklv v;dpon dg;lkvnvdzlk ldgvkj fUn ;fdviofn oFDNoiu fdhvdfb du pd ohd9puhgelngdhdgojndvjh glbdv fbkl;jFDN zp A:wjknf lfhfb;n vfublfkjdvu vilhb bulh</p>
    </body>
</html>
-->
{!! Form::open(['id' => 'data_form', 'method' =>'POST']) !!}
                      <div class="modal-body">
                            <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p>                      
                            
                                <div class="form-group">
                                    {{Form::label('first_name', 'Fullname')}}
                                    {{Form::text('first_name', '', ['id' => 'first_name', 'class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                                <div class="form-group">
                                        {{Form::label('last_name', 'Fname')}}
                                        {{Form::text('last_name', '', ['id' => 'last_name', 'class' => 'form-control', 'placeholder' => ''])}}
                                    </div>
                                              
                            
                      </div>
                      <div class="modal-footer">
                            <div class="col-md-12">
                                    {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                            </div>              
                      </div>
                      {!! Form::close() !!}



                      <br>
                    <a href="{{URL::to('/admin/test/pdf')}}">DOnwload</a>
                      @if(!empty($sample_data))  <table>
                          <tr>
                              <td>First Name</td>
                              <td>LAst Name</td>
                          </tr>

                          
                                @foreach ($sample_data as $data)
                                    <tr>
                                        <td>{{$data->first_name}}</td>
                                        <td>{{$data->last_name}}</td>
                                    </tr>
                                @endforeach
                           

                        
                      </table> @endif