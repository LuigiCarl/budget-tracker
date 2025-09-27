@extends('layouts.docs')

@section('title', 'Buttons')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<h1>Buttons</h1>

<p class="text-xl text-muted-foreground">
    A collection of beautiful, accessible button components built with Tailwind CSS.
</p>

## Basic Usage

The most basic button usage:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
        Button
    </button>
</div>

<x-docs.code language="php" title="Basic Button">
<button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
    Button
</button>
</x-docs.code>

## Variants

Different button styles for different use cases:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <div class="flex flex-wrap gap-4">
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
            Default
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            Secondary
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2">
            Destructive
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 border-dashed">
            Outline
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            Ghost
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary underline-offset-4 hover:underline h-10 px-4 py-2">
            Link
        </button>
    </div>
</div>

<x-docs.code language="html" title="Button Variants">
<!-- Default -->
<button class="btn-primary">Default</button>

<!-- Secondary -->
<button class="btn-secondary">Secondary</button>

<!-- Destructive -->
<button class="btn-destructive">Destructive</button>

<!-- Outline -->
<button class="btn-outline">Outline</button>

<!-- Ghost -->
<button class="btn-ghost">Ghost</button>

<!-- Link -->
<button class="btn-link">Link</button>
</x-docs.code>

## Sizes

Different button sizes:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <div class="flex items-center gap-4">
        <button class="inline-flex items-center justify-center rounded-md text-xs font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-7 px-2">
            Small
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
            Default
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-base font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8">
            Large
        </button>
    </div>
</div>

<x-docs.code language="html" title="Button Sizes">
<!-- Small -->
<button class="btn-primary btn-sm">Small</button>

<!-- Default -->
<button class="btn-primary">Default</button>

<!-- Large -->
<button class="btn-primary btn-lg">Large</button>
</x-docs.code>

## With Icons

Buttons with icons for better visual context:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <div class="flex flex-wrap gap-4">
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="M12 5v14"></path>
            </svg>
            Add Item
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7,10 12,15 17,10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Download
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2">
            Delete
            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18"></path>
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
            </svg>
        </button>
    </div>
</div>

<x-docs.code language="html" title="Buttons with Icons">
<!-- Icon before text -->
<button class="btn-primary">
    <svg class="mr-2 h-4 w-4"><!-- ... --></svg>
    Add Item
</button>

<!-- Icon after text -->
<button class="btn-destructive">
    Delete
    <svg class="ml-2 h-4 w-4"><!-- ... --></svg>
</button>
</x-docs.code>

## Loading State

Show loading indicators for async operations:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <div class="flex gap-4">
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" disabled>
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading...
        </button>
    </div>
</div>

<x-docs.code language="html" title="Loading Button">
<button class="btn-primary" disabled>
    <svg class="animate-spin -ml-1 mr-3 h-4 w-4"><!-- spinner svg --></svg>
    Loading...
</button>
</x-docs.code>

## Disabled State

Buttons can be disabled:

<div class="my-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg border">
    <div class="flex gap-4">
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" disabled>
            Disabled
        </button>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2" disabled>
            Disabled
        </button>
    </div>
</div>

<x-docs.code language="html" title="Disabled Buttons">
<button class="btn-primary" disabled>Disabled</button>
<button class="btn-secondary" disabled>Disabled</button>
</x-docs.code>

## CSS Classes

Here are the utility classes for different button styles:

<x-docs.code language="css" title="Button Base Classes">
/* Base button styles */
.btn {
    @apply inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors;
    @apply focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2;
    @apply disabled:pointer-events-none disabled:opacity-50;
}

/* Variants */
.btn-primary {
    @apply btn bg-primary text-primary-foreground hover:bg-primary/90;
}

.btn-secondary {
    @apply btn border border-input bg-background hover:bg-accent hover:text-accent-foreground;
}

.btn-destructive {
    @apply btn bg-destructive text-destructive-foreground hover:bg-destructive/90;
}

.btn-ghost {
    @apply btn hover:bg-accent hover:text-accent-foreground;
}

/* Sizes */
.btn-sm {
    @apply h-7 px-2 text-xs;
}

.btn-lg {
    @apply h-11 px-8 text-base;
}
</x-docs.code>

## Accessibility

Our buttons are built with accessibility in mind:

- ✅ **Keyboard Navigation** - Fully accessible via keyboard
- ✅ **Focus Indicators** - Clear focus rings for keyboard users
- ✅ **Screen Reader Support** - Proper semantic HTML elements
- ✅ **Color Contrast** - WCAG AA compliant color combinations
- ✅ **Loading States** - Disabled state during async operations

<x-docs.callout type="info" title="Accessibility Tips">
    - Use descriptive text or `aria-label` attributes
    - Include loading states for async operations
    - Test with keyboard navigation
    - Ensure sufficient color contrast
</x-docs.callout>

## Examples in Context

### Form Buttons

<x-docs.code language="html" title="Form Actions">
<form>
    <!-- Form fields -->
    <div class="flex justify-end space-x-2">
        <button type="button" class="btn-secondary">
            Cancel
        </button>
        <button type="submit" class="btn-primary">
            Save Changes
        </button>
    </div>
</form>
</x-docs.code>

### Card Actions

<x-docs.code language="html" title="Card with Actions">
<div class="card">
    <div class="card-header">
        <h3>Project Settings</h3>
    </div>
    <div class="card-content">
        <p>Configure your project settings here.</p>
    </div>
    <div class="card-footer">
        <button class="btn-outline btn-sm">
            Reset
        </button>
        <button class="btn-primary btn-sm">
            Update
        </button>
    </div>
</div>
</x-docs.code>

<x-docs.callout type="success" title="Ready to Use">
    These button components are ready to use in your Laravel application. They work seamlessly with your existing Tailwind CSS setup and maintain consistency across your application.
</x-docs.callout>
@endsection