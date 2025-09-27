
<div class="flex items-center gap-4 px-4">
    @foreach (['en' => 'EN', 'pl' => 'PL', 'de'=>'DE'] as $locale => $flag)
        <a href="{{ route('language.switch', $locale) }}"
           class="@if(app()->getLocale() === $locale) text-bold ring-2 ring-primary-500  rounded-full @endif"
           aria-label="Switch to {{ $locale }}" style="width:20px; display: inline-block;">
            @php
                $componentName = 'flag-language-' . $locale;
                $classes = 'w-6 h-6 rounded-full';
             @endphp
             <span class="text-2xl">
                    <x-dynamic-component :component="$componentName" :class="$classes" />
            </span>
        </a>
    @endforeach
</div>