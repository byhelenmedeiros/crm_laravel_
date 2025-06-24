<?php
namespace App\Http\Controllers\Aux;

use App\Http\Controllers\Controller;
use App\Models\AuxZona;
use Illuminate\Http\Request;

class AuxZonaController extends Controller
{
    public function index()
    {
        $zonas = AuxZona::orderBy('order')->get();
        return view('auxtables.zonas.index', compact('zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'codigo_postal_inicio' => 'required|string|max:4',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        AuxZona::create($request->all());

        return redirect()->route('aux.zonas.index')->with('success', 'Zona criada com sucesso.');
    }

    public function update(Request $request, AuxZona $zona)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'codigo_postal_inicio' => 'required|string|max:4',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        $zona->update($request->all());

        return redirect()->route('aux.zonas.index')->with('success', 'Zona atualizada com sucesso.');
    }

    public function destroy(AuxZona $zona)
    {
        $zona->delete();
        return redirect()->route('aux.zonas.index')->with('success', 'Zona removida.');
    }

    public function massDestroy(Request $request)
    {
        AuxZona::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Zonas eliminadas com sucesso.']);
    }
}
