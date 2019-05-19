<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Amortizacion;
use App\Prestamo;
class AmortizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//07/05/19
    public function index()
    {
        return view('amortizacion.index');
    }
//07/05/19 
    public function buscar(Request $request){

        //dd($request);
//17/05/19
        $reglas = array(
            'ci'=> 'required|numeric|exists:personas',
            );
        $mensaje = array(
            'ci.exists'=>'El CI no está almacenado en la DB'
            );
        $errores = $this->validate(request(),$reglas,$mensaje); //redirecciona con errors



        $socio = Persona::where('ci',$request['ci'])->get()->last()->socio;

        if(isset($socio)){
            $prestamo = Prestamo::where('socio_id',$socio->id)
                        ->where('estado',1)->get()->last(); 
            //$prestamo = $socio->prestamos->last();
            if(isset($prestamo)) {
                $amortizacion = $prestamo->amortizaciones;
                if(isset($amortizacion))
                   $total = $amortizacion->sum('capital');
//10/05/19
               $cuotas = count($amortizacion);
               $saldo = $prestamo->monto - $total;
               $capital = $saldo/($prestamo->plazo - $cuotas);
               $interes = $saldo*$prestamo->tasa_interes/12/100;

               $datos['socio'] = $socio->persona;
               $datos['numero'] = $socio->numero;
               $datos['saldo'] = $saldo;
               $datos['capital'] = $capital;              //¿cómo calcularía la nueva cifra? chan chan chan...., me muero, me muero chu chu chu, ViERNES!!!:D :(
               $datos['interes'] = $interes;
               $datos['cuotas'] = $cuotas;
               $datos['prestamo_id'] = $prestamo->id;
               return view('amortizacion.create')->with('datos',$datos);
            } else   //17/05/19
                 return redirect('amortizaciones')->with('mensaje','El socio no tiene prestamos vigentes')
                        ->withInput();
        }else {   //17/05/19
            return redirect('amortizaciones')->with('mensaje','El CI no pertenece a un socio');
        }
        //return "No es socio";    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//17/05/19
        $min = round($request['capital'] + $request['interes'],2); //monto mínimo a cancelar
        $max = round($request['saldo'] + $request['interes'],2);  //monto máximo a cancelar
        $regla = array(
            'monto' => 'required|numeric|min:'.$min.'|max:'.$max, 
            );
        $this->validate(request(),$regla);

        $amortizacion = new Amortizacion;
        $amortizacion->capital = $request['monto'] - $request['interes'];
        $amortizacion->interes = $request['interes'];
        $amortizacion->seguro = 0;
        $amortizacion->prestamo_id = $request['prestamo_id'];
        $amortizacion->cajera_id = 1;
        //AYUDA!!!! (realizar validación)el capital no puede ser mayor al saldo, ¿cómo se haría eso?, chan chan chan
        //PRACTICA 2-> validacion en este metodo
        $amortizacion->save();

//17/05/19
        $prestamo = Prestamo::find($request['prestamo_id']);
        $capital = $prestamo->amortizaciones->sum('capital');      
        if ($capital == $prestamo->monto) {
            $prestamo -> estado = 0;
            $prestamo -> save();
        }
        return redirect('amortizaciones')->with('mensaje','Amortización exitosa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
