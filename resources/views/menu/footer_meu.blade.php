<ul class="footer-address-list link-hover">
    @foreach ($items as $item)
    <li>
        <a  href="{{ $item->url}}" target="{{ $item->target?'_blank':'_self' }}" > {{ $item->title }}</a>
    </li>
    @endforeach
</ul>
