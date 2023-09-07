<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $tareas = Tarea::where('estado', '>', 0)->where('user_id', $userId)->get();
            return view('dashboard', compact('tareas'));
        } else {
            return view('index');
        }
    }

    public function estado(Request $request) {
        $tareaId = $request->input('tarea_id');
        $Estado =  (int)$request->input('nuevo_estado');


        $tarea = Tarea::find($tareaId);

        if ($tarea && $tarea->estado + $Estado < 4) {

           
                $tarea->estado += $Estado;
                $tarea->save();
                return response()->json(['success' => true, 'estado' =>  $tarea->estado]);
            
         
        } else {
            return response()->json(['success' => false]);
        }
    }

    
    public function show($id)
    {

        $validator = validator(['id' => $id], [
            'id' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $tarea = tarea::findOrFail($id);
           
            return $tarea;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El tarea ' . $id . ' no existe no fue encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }

    }

    
    public function create(Request $request)
    {

       
        try {
            // Validación y creación de la tarea
            $validator = validator($request->all(), [
                'user_id' => 'required|exists:users,id',
                'nombre' => 'required',
                'descripcion' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
            Tarea::create($request->all());

            return redirect()->route('dashboard')->with('message', 'Tarea creada correctamente');
        } catch (Exception $e) {
            
            return redirect()->route('dashboard')->with(['error' => 'Ocurrió un error al crear la tarea'], 500);
        } catch (QueryException $e) {
            $errormsj = $e->getMessage();
        
            if (strpos($errormsj, 'Duplicate entry') !== false) {
                preg_match("/Duplicate entry '(.*?)' for key '(.*?)'/", $errormsj, $matches);
                $duplicateValue = $matches[1] ?? '';
                $duplicateKey = $matches[2] ?? '';
        
                return response()->json(['error' => "No se puede realizar la acción, el valor '$duplicateValue' ya está duplicado en el campo '$duplicateKey'"], 422);
            }
            return response()->json(['error' => 'Error en la acción realizada: ' . $errormsj], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No se pudo registrar el tarea'.$e->getMessage()], 404);
        } 
    }

    public function update($id,Request $request)
    {
        
        try {
            $validator = validator($request->all(), [
                'user_id'=> 'required|exists:users,id',
                'nombre'=> 'required',
                'descripcion'=> 'required',
                'estado'=> 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tarea = tarea::findOrFail($id);
            $tarea->update($request->all());
            $tarea->save();

           

            return response()->json(['msj' => 'tarea actualizado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El tarea ' . $id . ' no existe no fue encontrado'], 404);
        } catch (QueryException  $e) {
            $errormsj = $e->getMessage();

            if (strpos($errormsj, 'Duplicate entry') !== false) {
                preg_match("/Duplicate entry '(.*?)' for key/", $errormsj, $matches);
                $duplicateValue = $matches[1] ?? 'Tienes un valor que';

                return response()->json(['error' => 'Error: ' . $duplicateValue . ' ya esta en uso'], 422);
            }

            return response()->json(['error' => 'Error en la acción realizada'.$errormsj], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }

    public function destroy($id)
    {
        $validator = validator(['id' => $id], [
            'id' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $tarea = tarea::findOrFail($id);
            if ($tarea->estado) {
                $tarea->estado = 0;
                $tarea->save();
                return response()->json(['success' => true, 'estado' =>  'Tarea eliminada correctamente']);
          
            }

           

            return response()->json(['success' => true, 'estado' =>  'Este Tarea ya ha sido eliminado']);
          
        

        } catch (Exception $e) {
            
            return response()->json(['success' => true, 'estado' =>  'Ocurrió un error al borrar la tarea']);
          
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El Tarea ' . $id . ' no existe no fue encontrado'], 404);
        }
    }

}
