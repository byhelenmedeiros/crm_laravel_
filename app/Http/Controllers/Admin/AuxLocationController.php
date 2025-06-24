<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuxLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuxLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:manage-aux-data']);
    }

    public function index()
    {
        // Passa os três tipos para o front
        return Inertia::render('Admin/AuxLocations/Index', [
            'countries'      => AuxLocation::where('type','country')->active()->orderBy('order')->get(),
            'districts'      => AuxLocation::where('type','district')->active()->orderBy('order')->get(),
            'municipalities' => AuxLocation::where('type','municipality')->active()->orderBy('order')->get(),
        ]);
    }

    public function create(string $type)
    {
        // Para country, parentList fica vazio
        $parents = $type === 'country'
            ? collect()
            : AuxLocation::where('type', $type === 'district' ? 'country' : 'district')
                         ->active()->orderBy('order')->get();

        return Inertia::render('Admin/AuxLocations/Form', [
            'location'   => null,
            'type'       => $type,
            'parentList' => $parents,
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => $type === 'country' ? 'nullable' : 'required|exists:aux_locations,id',
            'order'     => 'nullable|integer',
            'active'    => 'boolean',
        ]);

        $data['type'] = $type;
        AuxLocation::create($data);

        return redirect()->route('admin.aux-locations.index')
                         ->with('success', ucfirst($type).' criado.');
    }

    public function edit(AuxLocation $location)
    {
        $type    = $location->type;
        $parents = $type === 'country'
            ? collect()
            : AuxLocation::where('type', $type === 'district' ? 'country' : 'district')
                         ->active()->orderBy('order')->get();

        return Inertia::render('Admin/AuxLocations/Form', [
            'location'   => $location,
            'type'       => $type,
            'parentList' => $parents,
        ]);
    }

    public function update(Request $request, AuxLocation $location): RedirectResponse
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => $location->type === 'country' ? 'nullable' : 'required|exists:aux_locations,id',
            'order'     => 'nullable|integer',
            'active'    => 'boolean',
        ]);

        $location->update($data);

        return back()->with('success', ucfirst($location->type).' atualizado.');
    }

    public function destroy(AuxLocation $location): RedirectResponse
    {
        $location->delete();
        return back()->with('success', ucfirst($location->type).' excluído.');
    }
}
