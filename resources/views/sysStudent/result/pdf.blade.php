<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Subject</td>
                <td>CA</td>
                <td>Exam</td>
            </tr>
            </thead>
            <tbody>
                @foreach ($result as $res)
                    <tr>
                    
                        <td>{{$res->subject_title}}</td>
                        <td>{{$res->ca1}}</td>
                        <td>{{$res->exam}}</td>
                
                    </tr>
                @endforeach
                

                
            </tbody>
        </table>
    </body>
</html>