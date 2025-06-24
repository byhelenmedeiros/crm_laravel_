<x-auxtables.data-table
    :items="$zonaComerciais"
    title="Zonas Comerciais"
    storeRoute="aux.zona-comerciais.store"
    destroyRoute="aux.zona-comerciais.destroy"
    massDestroyRoute="aux.zona-comerciais.massDestroy"
    :columns="[
        ['label' => 'Nome', 'field' => 'nome'],
        ['label' => 'Zona', 'field' => 'zona.nome'],
        ['label' => 'Ativo', 'field' => 'active'],
    ]"
/>
