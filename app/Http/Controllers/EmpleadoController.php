<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('empleados.index', [
            'empleados' => Empleado::with('departamento')->orderBy('numero')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::all(); //para obtener todos los departamentos para que se ve despues en el desplegable
        return view('empleados.create', [
            'departamentos' => $departamentos, //para el despegable
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|max:3|unique:empleados,numero',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);
        $empleado = Empleado::create($validated);
        session()->flash('exito', 'Empleado creado correctamente.');
        return redirect()->route('empleados.index', $empleado);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        $departamentos = Departamento::all(); //para obtener todos los departamentos para que se ve despues en el desplegable
        return view('empleados.edit', [
            'empleado' => $empleado,
            'departamentos' => $departamentos, //Para el desplegable
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'numero' => [
                'required',
                'max:2',
                Rule::unique('empleados')->ignore($empleado),
            ],
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);
        $empleado->fill($validated);
        $empleado->save();
        session()->flash('exito', 'Empleado modificado correctamente.');
        return redirect()->route('empleados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index');    }
}
