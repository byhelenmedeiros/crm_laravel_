<?php
namespace App\Http\Controllers\Aux;

use App\Http\Controllers\Controller;
use App\Models\AuxVendor;
use Illuminate\Http\Request;

class AuxVendorController extends Controller
{
    public function index()
    {
        $vendors = AuxVendor::with('zonaComercial')->orderBy('nome')->get();
        return view('auxtables.vendors.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_comercial_id' => 'required|exists:aux_zona_comerciais,id',
            'email' => 'nullable|email',
            'telemovel' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
        ]);

        AuxVendor::create($request->all());

        return redirect()->route('aux.vendors.index')->with('success', 'Vendedor criado.');
    }

    public function update(Request $request, AuxVendor $vendor)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'zona_comercial_id' => 'required|exists:aux_zona_comerciais,id',
            'email' => 'nullable|email',
            'telemovel' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
        ]);

        $vendor->update($request->all());

        return redirect()->route('aux.vendors.index')->with('success', 'Vendedor atualizado.');
    }

    public function destroy(AuxVendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('aux.vendors.index')->with('success', 'Vendedor removido.');
    }

    public function massDestroy(Request $request)
    {
        AuxVendor::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Vendedores eliminados.']);
    }
}
