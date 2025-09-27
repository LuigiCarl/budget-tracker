@extends('layouts.docs')

@section('title', 'Troubleshooting')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Troubleshooting</h1>

<p class="text-xl text-muted-foreground">
    Common issues and solutions for Laravel development.
</p>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for troubleshooting guides.
</x-docs.callout>
@endsection