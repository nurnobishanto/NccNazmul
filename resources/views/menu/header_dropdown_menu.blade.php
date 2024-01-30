
<div class="nx-dropdown menu-dorpdown">
    <div class="sub-menu-section">
        <div class="sub-menu-center-block">
            <div class="sub-menu-column smfull">
                <ul>
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
                                {{ $item->title }}
                            </a>
                            @if(!$originalItem->children->isEmpty())
                                @include('menu.header_dropdown_menu', ['items' => $originalItem->children, 'options' => $options])
                            @endif
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</div>
