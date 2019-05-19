<html>
<head>
	<title>Buscar socios con prestamos</title>
</head>
<body>
	@if(session('mensaje'))
	   {{ session('mensaje') }} <br>
	@endif

	{{ Form:: open(['route'=>'amortizacion.buscar', 'method'=>'get']) }}
	   {{ Form::label('ci','C.I.:') }}
	   {{ Form::text('ci','',['id'=>'ci','placeholder'=>'Introduzca el C.I.']) }}
	   <br>
	   {{ Form::reset('Borrar') }}
	   {{ Form::submit('Buscar') }}
	{{ Form::close() }}

	@if($errors->has('ci'))
	   @foreach ($errors->all() as $error)
	      <font color="red">{{ $error }}</font>
	   @endforeach
	@endif

</body>
</html>