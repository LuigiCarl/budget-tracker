@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'iconBg' => 'bg-primary',
    'hover' => true
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-border bg-card text-card-foreground shadow-sm' . ($hover ? ' card-hover' : '')]) }}>
    @if($title || $icon)
        <div class="p-6 pb-4">
            <div class="flex items-center {{ $description ? 'space-x-4' : 'justify-center' }}">
                @if($icon)
                    <div class="p-3 {{ $iconBg }} rounded-full">
                        {!! $icon !!}
                    </div>
                @endif
                @if($title)
                    <div>
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                        @if($description)
                            <p class="text-sm text-muted-foreground">{{ $description }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="{{ ($title || $icon) ? 'px-6 pb-6' : 'p-6' }}">
        {{ $slot }}
    </div>
</div>