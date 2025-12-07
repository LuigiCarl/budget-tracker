@extends('layouts.docs')

@section('title', 'Deployment')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#F59E0B]/10 text-[#F59E0B] text-xs font-semibold">Advanced</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Deployment</h1>
    <p class="text-lg text-muted-foreground">Deploy your Laravel application to production environments.</p>
</div>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for deployment guides.
</x-docs.callout>
@endsection