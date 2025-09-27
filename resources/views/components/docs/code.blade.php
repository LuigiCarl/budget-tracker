@props([
    'language' => 'php',
    'title' => null,
    'filename' => null,
    'highlightLines' => null,
])

<div class="relative group">
    @if($title || $filename)
    <div class="flex items-center justify-between rounded-t-md border border-b-0 border-border bg-muted px-4 py-2">
        <div class="flex items-center gap-2">
            @if($filename)
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-mono">{{ $filename }}</span>
                </div>
            @endif
            @if($title && !$filename)
                <span class="text-sm font-medium text-foreground">{{ $title }}</span>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-muted-foreground uppercase">{{ $language }}</span>
            <button class="copy-btn inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100">
                <svg class="copy-icon h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                </svg>
                <svg class="check-icon h-3 w-3 hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20,6 9,17 4,12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <pre class="language-{{ $language }} {{ $title || $filename ? 'rounded-t-none' : '' }} relative overflow-x-auto bg-muted border border-border p-4"><code class="language-{{ $language }}">{{ trim($slot) }}</code></pre>

    @if(!$title && !$filename)
    <button class="copy-btn absolute top-3 right-3 inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 opacity-0 group-hover:opacity-100">
        <svg class="copy-icon h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
            <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
        </svg>
        <svg class="check-icon h-3 w-3 hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20,6 9,17 4,12"/>
        </svg>
    </button>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler for this code block
    const copyBtns = document.querySelectorAll('.copy-btn');
    copyBtns.forEach(btn => {
        if (!btn.hasAttribute('data-initialized')) {
            btn.setAttribute('data-initialized', 'true');
            btn.addEventListener('click', async function() {
                const codeBlock = this.closest('.group').querySelector('code');
                const text = codeBlock.textContent;
                
                try {
                    await navigator.clipboard.writeText(text);
                    
                    const copyIcon = this.querySelector('.copy-icon');
                    const checkIcon = this.querySelector('.check-icon');
                    
                    copyIcon.classList.add('hidden');
                    checkIcon.classList.remove('hidden');
                    
                    setTimeout(() => {
                        copyIcon.classList.remove('hidden');
                        checkIcon.classList.add('hidden');
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
            });
        }
    });
});
</script>