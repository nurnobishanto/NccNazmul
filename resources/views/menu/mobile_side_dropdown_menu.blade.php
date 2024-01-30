<ul>
    @foreach ($items as $item)
        @php
            $originalItem = $item;
        @endphp

        <li>
            <a  href="{{ $item->url }}" target="{{ $item->target?'_blank':'_self' }}">
                {!! $item->icon_class !!}
                {{ $item->title }}
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('menu.header_dropdown_menu', ['items' => $originalItem->children,])
            @endif
        </li>
    @endforeach
</ul>
