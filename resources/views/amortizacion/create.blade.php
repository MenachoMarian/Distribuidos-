<html>
<head>
	<title>Pago de crédito</title>
</head>
<body>

	C.I.: {{ $datos['socio']->ci }} <br>
	Socio: {{ $datos['socio']->nombres.' '.
	          $datos['socio']->paterno.' '.$datos['socio']->materno }}<br>
	Número: {{ $datos['numero'] }}<br>
	Saldo: {{ $datos['saldo'] }} Bs.<br>
	Nro. de cuotas: {{ $datos['cuotas'] }}<br>

	{{ Form::open(['route'=>'pagar.cuota', 'method'=>'post']) }}

	   {{ Form::label('monto','Monto a amortizar: ') }}
	   {{ Form::text('monto', round($datos['capital'] + $datos['interes'],2 )) }}
	   <br>
	   {{ Form::hidden('prestamo_id', $datos['prestamo_id']) }}
	   {{ Form::hidden('saldo', $datos['saldo']) }}
	   {{ Form::hidden('capital',$datos['capital']) }}
	   {{ Form::hidden('interes', $datos['interes']) }}
	   {{ Form::reset('Borrar') }}
	   {{ Form::submit('Pagar') }}
	{{ Form::close() }}

	@if($errors->has('monto'))
	   <font color="red">{{ $errors->first('monto',':message') }}</font>
	@endif

   
</body>
</html>