<ul class="navbar-nav m-auto mb-2 mb-lg-0">
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
        <li class="nav-item @if(!$originalItem->children->isEmpty()) dropdown @endif">
            <a class="nav-link {{ $isActive }}
            @if(!$originalItem->children->isEmpty()) dropdown-toggle @endif"
               @if(!$originalItem->children->isEmpty())
                   id="{{$btnId}}"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false"
               @endif
               href="{{ $item->url }}"
               target="{{ $item->target?'_blank':'_self' }}">
                {!! $item->icon_class !!}
                <span>{{ $item->title }}</span>
            </a>
            @if(!$originalItem->children->isEmpty())
                @include('menu.dropmenu', ['items' => $originalItem->children, 'options' => $options,'btnId' => $btnId])
            @endif
        </li>
    @endforeach
</ul>
