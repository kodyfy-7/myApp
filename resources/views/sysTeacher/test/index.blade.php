@if(!empty($classrooms))
                        <div class="dropdown dropright">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Select Class</button>
                            <div class="dropdown-menu">
                    
                                @forelse($classrooms as $classroom)
                                        <a class="dropdown-item" href="/teacher/test/{{$classroom->id}}">{{$classroom->title}}</a>
                                        
                                    @empty
                                        <div class="col-md-12"><p>No data</p></div>
                                @endforelse
                            </div>
                        </div>
                    @endif


                    @if(!empty($students))
                    {!! Form::open(['action' => 'TestController@store' ,'id' => 'data_form', 'method' =>'POST']) !!}
                    <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p>  
                      <div class="form-group">
                          <select name="subject_id" class="form-control" id="subject_id">
                              <option value="">Select subject</option>
                              @foreach($subjects as $subject)
                                  <option value="{{$subject->id}}">{{$subject->subject_title}}</small>
                                  </option>
                              @endforeach
                          </select>    
                      </div>  
                      <table class="table table-bordered" id="data_table">
                          <thead>
                              <tr>
                                  <th>Student</th>
                                  <th>Score</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($students as $student)
                                @foreach ($student->results as $result)           
                                  <tr>
                                    <td>
                                      <input type="text" value="{{$student->name}}" class="form-control" disabled></td>
                                    <td>
                                      {{Form::text('score[]', '', ['id' => 'score', 'class' => 'form-control'])}}{{Form::hidden('classroom_id[]', $id, ['id' => 'classroom_id', 'class' => 'form-control'])}} <input type="hidden" name="result_id[]" id="result_id" value="{{$result->id}}" />
                                    </td>
                                  </tr>  
                                  @endforeach                                                 
                              @endforeach
                          </tbody>
                      </table>
                      <div class="col-md-12">
                          {{Form::hidden('action', '', ['id' => 'action', 'class' => 'form-control'])}}
                          
                          <input type="hidden" name="total_item" id="total_item" value="{{$studentNum}}" />
                          {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                      </div>                            
                  {!! Form::close() !!}
                @endif