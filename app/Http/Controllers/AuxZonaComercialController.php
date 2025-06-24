<?php
namespace App\Http\Controllers\Aux;

use App\Http\Controllers\Controller;
use App\Models\AuxZonaComercial;
use Illuminate\Http\Request;

class AuxZonaComercialController extends Controller
{
    public function index()
    {
        $zonaComerciais = AuxZonaComercial::with('zona')->orderBy('nome')->get();
        return view('auxtables.zona_comerciais.index', compact('zonaComerciais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_id' => 'required|exists:aux_zonas,id',
            'active' => 'nullable|boolean',
        ]);

        AuxZonaComercial::create($request->all());

        return redirect()->route('aux.zona-comerciais.index')->with('success', 'Zona Comercial criada.');
    }

    public function update(Request $request, AuxZonaComercial $zonaComercial)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_id' => 'required|exists:aux_zonas,id',
            'active' => 'nullable|boolean',
        ]);

        $zonaComercial->update($request->all());

        return redirect()->route('aux.zona-comerciais.index')->with('success', 'Zona Comercial atualizada.');
    }

    public function destroy(AuxZonaComercial $zonaComercial)
    {
        $zonaComercial->delete();
        return redirect()->route('aux.zona-comerciais.index')->with('success', 'Removido.');
    }

    public function massDestroy(Request $request)
    {
        AuxZonaComercial::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Zonas Comerciais removidas.']);
    }
}
