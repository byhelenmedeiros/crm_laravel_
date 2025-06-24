<x-auxtables.data-table
    :items="$zonas"
    title="Zonas"
    storeRoute="aux.zonas.store"
    destroyRoute="aux.zonas.destroy"
    massDestroyRoute="aux.zonas.massDestroy"
    :columns="[
        ['label' => 'Nome', 'field' => 'nome'],
        ['label' => 'Código Postal', 'field' => 'codigo_postal_inicio'],
        ['label' => 'Ordem', 'field' => 'order'],
        ['label' => 'Ativo', 'field' => 'active'],
    ]"
/>
