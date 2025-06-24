<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuxLocation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuxTableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:manage-aux-data']);
    }

    protected $tables = [
        'countries'      => 'aux_countries',
        'districts'      => 'aux_districts',
        'municipalities' => 'aux_municipalities',
        'client-groups'  => 'aux_client_groups',
    ];

    protected function getTable(string $key): string
    {
        abort_unless(isset($this->tables[$key]), 404);
        return $this->tables[$key];
    }

    public function index(string $typeKey)
    {
        $table = $this->getTable($typeKey);

        $items = (new AuxLocation())
            ->setTable($table)
            ->orderBy('order')
            ->get();

        return Inertia::render('Admin/AuxData/Index', [
            'typeKey'   => $typeKey,
            'typeLabel' => ucwords(str_replace('-', ' ', $typeKey)),
            'items'     => $items,
        ]);
    }

    public function create(string $typeKey)
    {
        return Inertia::render('Admin/AuxData/Form', [
            'typeKey'   => $typeKey,
            'typeLabel' => ucwords(str_replace('-', ' ', $typeKey)),
            'item'      => null,
        ]);
    }

    public function store(Request $request, string $typeKey)
    {
        $table = $this->getTable($typeKey);
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'order'  => 'nullable|integer',
            'active' => 'boolean',
        ]);

        (new AuxLocation())
            ->setTable($table)
            ->create($data);

        return redirect()->route('admin.aux-data.index', $typeKey)
                         ->with('success', "{$typeKey} criado.");
    }

    public function edit(string $typeKey, $id)
    {
        $table = $this->getTable($typeKey);
        $item  = (new AuxLocation())->setTable($table)->findOrFail($id);

        return Inertia::render('Admin/AuxData/Form', [
            'typeKey'   => $typeKey,
            'typeLabel' => ucwords(str_replace('-', ' ', $typeKey)),
            'item'      => $item,
        ]);
    }

    public function update(Request $request, string $typeKey, $id)
    {
        $table = $this->getTable($typeKey);
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'order'  => 'nullable|integer',
            'active' => 'boolean',
        ]);

        (new AuxLocation())
            ->setTable($table)
            ->findOrFail($id)
            ->update($data);

        return back()->with('success', "{$typeKey} atualizado.");
    }

    public function destroy(string $typeKey, $id)
    {
        $table = $this->getTable($typeKey);
        (new AuxLocation())->setTable($table)->destroy($id);

        return back()->with('success', "{$typeKey} excluído.");
    }
}
