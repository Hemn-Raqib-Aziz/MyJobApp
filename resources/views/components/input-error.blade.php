{{-- resources/views/components/input-error.blade.php --}}
@props(['field' => null, 'autoDismiss' => 5000])

@if($field)
    {{-- Field-specific error --}}
    @error($field)
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, {{ $autoDismiss }})" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="responsive-error" role="alert">
                <div class="error-indicator"></div>
                <div class="error-message-content">
                    <svg class="error-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            </div>
        </div>
    @enderror
@else
    {{-- General/session error --}}
    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, {{ $autoDismiss }})" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="responsive-error" role="alert">
                <div class="error-indicator"></div>
                <div class="error-message-content">
                    <svg class="error-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Also handle any validation errors without specific field --}}
    @if($errors->any() && !$errors->has('*'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, {{ $autoDismiss }})" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="responsive-error" role="alert">
                <div class="error-indicator"></div>
                <div class="error-message-content">
                    <svg class="error-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <span>{{ $error }}</span>
                            @if(!$loop->last)<br>@endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

<style>
    .responsive-error {
        display: flex;
        align-items: stretch;
        background: #fff5f5;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .error-indicator {
        width: 3px;
        background: #f56565;
        flex-shrink: 0;
    }
    
    .error-message-content {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #c53030;
        flex: 1;
    }
    
    .error-svg {
        width: 1rem;
        height: 1rem;
        color: #f56565;
        flex-shrink: 0;
    }
    
    @media (max-width: 640px) {
        .error-message-content {
            font-size: 0.75rem;
            padding: 0.625rem 0.875rem;
        }
    }
</style>