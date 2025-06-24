<x-auxtables.data-table
    :items="$vendors"
    title="Vendedores"
    storeRoute="aux.vendors.store"
    destroyRoute="aux.vendors.destroy"
    massDestroyRoute="aux.vendors.massDestroy"
    :columns="[
        ['label' => 'Nome', 'field' => 'nome'],
        ['label' => 'Zona Comercial', 'field' => 'zonaComercial.nome'],
        ['label' => 'Email', 'field' => 'email'],
        ['label' => 'Telemóvel', 'field' => 'telemovel'],
        ['label' => 'Ativo', 'field' => 'active'],
    ]"
/>
