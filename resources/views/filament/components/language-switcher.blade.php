<div class="flex items-center gap-4 px-4">
    @foreach (['en' => 'EN', 'pl' => 'PL', 'de'=>'DE'] as $locale => $flag)
 <a href="{{ route('language.switch', $locale) }}"
           class="@if(app()->getLocale() === $locale) ring-2 ring-primary-500 rounded-full @endif"
           aria-label="Switch to {{ $locale }}">
            <span class="text-2xl">{{ $flag }}</span>
        </a>
    @endforeach
</div>