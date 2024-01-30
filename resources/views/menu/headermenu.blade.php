<ul class="nav-list">
    @foreach ($items as $item)
        @php
            $originalItem = $item;
            $isActive = '';

            // Check if link is current
            if ($item->url == request()->url()) {
                $isActive = 'active';
            }
            $btnId = 'navbarScrollingDropdown'.$item->id
        @endphp
        @if(!$originalItem->children->isEmpty()) @endif
        <li class=" @if(!$originalItem->children->isEmpty()) sbmenu rpdropdown @endif">
            <a class="menu-links {{ $isActive }}"
               href="{{ $item->url }}"
               target="{{ $item->target?'_blank':'_self' }}">
                {!! $item->icon_class !!} {{ $item->title }}
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('menu.header_dropdown_menu', ['items' => $originalItem->children])
            @endif
        </li>
    @endforeach
</ul>
