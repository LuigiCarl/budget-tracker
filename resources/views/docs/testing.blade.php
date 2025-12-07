@extends('layouts.docs')

@section('title', 'Testing')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#F59E0B]/10 text-[#F59E0B] text-xs font-semibold">Advanced</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Testing</h1>
    <p class="text-lg text-muted-foreground">Testing strategies and tools for Laravel applications.</p>
</div>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for testing documentation.
</x-docs.callout>
@endsection