<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table class="table table-bordered">
      <tr>
        <td>
          {{$student->name}}
        </td>
        <td>
          {{$student->dob}}
        </td>
        <td>
                {{$student->classroom_id}}
              </td>
      </tr>
    </table>
  </body>
</html>