@extends('layouts.app')

@section('title', 'Zonas Estruturadas')

@section('content')
@include('components.auxtables.data-table', [
    'items' => $zonas,
    'title' => 'Zonas Estruturadas',
    'storeRoute' => 'aux.zonas-estruturadas.store',
    'destroyRoute' => 'aux.zonas-estruturadas.destroy',
    'massDestroyRoute' => 'aux.zonas-estruturadas.massDestroy',
    'columns' => [
        ['label' => 'Código Postal', 'field' => 'codigo_postal_inicio'],
        ['label' => 'Zona', 'field' => 'nome_zona'],
        ['label' => 'Zona Comercial', 'field' => 'nome_zona_comercial'],
        ['label' => 'Vendedor', 'field' => 'nome_vendedor'],
        ['label' => 'Email', 'field' => 'email_vendedor', 'type' => 'email'],
        ['label' => 'Telemóvel', 'field' => 'telemovel_vendedor'],
        ['label' => 'Ordem', 'field' => 'order', 'type' => 'number'],
        ['label' => 'Ativo', 'field' => 'active', 'type' => 'checkbox'],
    ]
])
@endsection
