<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuxCountry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuxCountryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:manage-aux-data']);
    }

    public function index()
    {
        $items = AuxCountry::orderBy('order')->get();
        return Inertia::render('Admin/AuxData/Index', [
            'typeKey' => 'countries',
            'typeLabel' => 'Países',
            'items' => $items,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/AuxData/Form', [
            'typeKey'   => 'countries',
            'typeLabel' => 'Países',
            'item'      => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'order'  => 'nullable|integer',
            'active' => 'boolean',
        ]);
        AuxCountry::create($data);
        return redirect()->route('admin.aux-countries.index')
                         ->with('success','País criado.');
    }

    public function edit(AuxCountry $aux_country)
    {
        return Inertia::render('Admin/AuxData/Form', [
            'typeKey'   => 'countries',
            'typeLabel' => 'Países',
            'item'      => $aux_country,
        ]);
    }

    public function update(Request $request, AuxCountry $aux_country): RedirectResponse
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'order'  => 'nullable|integer',
            'active' => 'boolean',
        ]);
        $aux_country->update($data);
        return back()->with('success','País atualizado.');
    }

    public function destroy(AuxCountry $aux_country): RedirectResponse
    {
        $aux_country->delete();
        return back()->with('success','País excluído.');
    }
}
