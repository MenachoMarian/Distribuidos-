<html>
<head>
	<title>Nueva persona</title>
</head>
<body>
	{{Form::open(array('route'=>'persona.store','method'=>'post')) }}
       {{ Form::label('ci','C.I: ') }}
       {{ Form::number('ci','0', ['id'=>'ci','required']) }}
       <br>   
       @if($errors -> has('ci'))
           <font color="red">{{$errors->first()}}</font><br>
       @endif
       {{ Form::label('nombres','Nombres: ')}}
       {{ Form::text('nombres','', ['id'=>'nombres',
       'placeholder'=>'Introduzca el nombre','required'])}}
       <br>
       {{ Form::label('paterno','Apellido paterno: ')}}
       {{ Form::text('paterno','', ['id'=>'paterno',
       'placeholder'=>'Introduzca el apellido paterno','required'])}}
       <br>
       {{ Form::label('materno','Apellido materno: ')}}
       {{ Form::text('materno','', ['id'=>'materno',
       'placeholder'=>'Introduzca el apellido materno','required'])}}
       <br>
       {{ Form::label('telefono','Telefono: ')}}
       {{ Form::number('telefono','', array("id"=>'telefono')) }}
       <br>
       {{ Form::label('email','Correo electronico: ')}}
       {{ Form::text('email','', ['id'=>'email',
       'placeholder'=>'Introduzca el correo','required'])}}
       <br>
       @if($errors -> has('email'))
          <font color="red">{{ $errors->first('email')}}</font><br>
       @endif
       {{ Form::label('password','Contraseña: ')}}
       {{ Form::password('password', ['id'=>'password',
       'placeholder'=>'Introduzca contraseña','required'])}}
       <br>
       {{ Form::label('password_confir','Confirmar contraseña: ') }}
       {{ Form::password('password_confir', ['id'=>'password_confir',
       'placeholder'=>'Introduzca contraseña','required'])}}
       <br>
       @if($errors -> has('password_confir'))
          <font color="red">{{$errors->first('password_confir',':message')}}</font><br>
      @endif

       {{ Form::reset('Borrar') }}
       {{ Form::submit('Guardar',['class'=>'']) }}

	{{ Form::close() }}

       
</body>
</html>