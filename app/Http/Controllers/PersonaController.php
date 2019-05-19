<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
class PersonaController extends Controller
{
    //
    public function index(){
    	$per=Persona::all(); //llamando al modelo
    	//dd($personas);
    	//return "Lista de personas";
    	return view('persona.index')->with('personas',$per);
    }
    public function create(){
    	return view("persona.create");
    }

    public function store(Request $request){
        //dd($request)
//14/05/19 
        $reglas = array(
            "ci" => 'required|min:100000|max:999999|numeric|unique:personas',
            'nombres' => 'required|String',
            'paterno' => 'String',
            'materno' => 'required|String',
            'telefono' => 'min:10000000|max:99999999|numeric',
            'email' => 'required|E-Mail',
            'password' => 'required|alpha_num',
            'password_confir' => 'required|same:password',
            );
        $mensajes = array(
            'ci.min' => 'El ci debe tener al menos 6 dígitos',
            'password_confir.required' => 'La confirmación de contraseña es obligatoria',
            'password_confir.same' => 'La contraseña y la confirmacion deben ser iguales',
            );
        $errores = $this->validate(request(),$reglas,$mensajes);
        //dd($errores);
        if($errores){
            $per = new Persona;
           /*$per->ci = $request['ci'];
           $per->nombres = $request['nombres'];
           $per->paterno = $request['paterno'];
           $per->materno = $request['materno'];
           $per->telefono = $request['telefono'];
           $per->email = $request['email'];
          $per->password = $request['password'];
          //dd($per)
         $per->save();*/
        $per->guardar($request);
        //return "persona guardada";
        return redirect('persona'); //redirect a modelo
        }
        
//14/05/19
        //$errores = $this->validate(request(),$reglas=array(),[$mensaje=array()]);
           //Accepted//Active URL //After(Date) //After or Equal(Date) //Alpha //Alpha Dash //Alpha numeric
           //Array //Before(Date) //Before or Equal(date) //Between //Boolean //Confirmed //Date //Date Equals
           //Date Format //Different //Digits // Digits Beetwen //Dimensions(Image Files) //Distinct ///E-Mail
           //Exists(Database) (ej: 'ci'=>'exists:personas') //File //Filled //Image(File) //In //In Array //Integer
           //IP Address //JSON //Max //MIME_Type //MIME_Type_By_File_Extension //Min //Nullable
           //Not In //Numeric //Present //Regular Expression (regex:) //Required //Required If
           //Requires Unless //Required With //Required With All //Requiresd Without //required Without All
           //Same //Size //String //Timezone //Unique(Database) (ej: 'ci'=> 'unique:personas') //URL
           //laravel.com
    }

//26/04/2019

    public function edit($id){
        $persona = Persona::find($id); //SELECT * FROM´personas where (id=$id)
        //Persona::where('id','<,>,<=,>=,<>', valor)->get()->first();

        return view('persona.edit')->with('persona',$persona);

    }

    public function update(Request $request){
        //dd($request)
        $persona = Persona::find($request['id']);
        $persona->nombres = $request['nombres'];
        $persona->paterno = $request['paterno'];
        $persona->materno = $request['materno'];
        $persona->telefono = $request['telefono'];
        $persona->save();
        return redirect('persona');
    }
    
    //30/04/19
    public function destroy($id){
        Persona::destroy($id); //detroy buscaa y elimina, tb es válido

        /*$persona = Persona::find($id);
        //dd($persona);
        //$persona->destroy();
        $persona->delete()*/
        return redirect('persona');
    }
}

//php artisan make:controller PersonaController