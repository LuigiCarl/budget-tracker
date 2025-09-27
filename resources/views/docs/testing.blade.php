@extends('layouts.docs')

@section('title', 'Testing')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Testing</h1>

<p class="text-xl text-muted-foreground">
    Testing strategies and tools for Laravel applications.
</p>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for testing documentation.
</x-docs.callout>
@endsection