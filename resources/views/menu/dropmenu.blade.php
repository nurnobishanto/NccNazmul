<ul class="dropdown-menu" aria-labelledby="{{$btnId}}">
    @foreach ($items as $item)
        @php
            $originalItem = $item;
            $isActive = null;
            // Check if link is current
            if($item->url == url()->current()){
                $isActive = 'active';
            }
        @endphp
        <li>
            <a class="dropdown-item" href="{{ $item->url }}" target="{{ $item->target?'_blank':'_self' }}">
                {!! $item->icon_class !!}
                <span>{{ $item->title }}</span>
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('menu.dropmenu', ['items' => $originalItem->children, 'options' => $options])
            @endif
        </li>
    @endforeach

    </ul>
