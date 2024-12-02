<h1>Pages</h1>
<ul>
    @foreach($pages as $page)
        <li>
            <a href="{{ route('pages.show', $page->id) }}">{{ $page->title }}</a>
        </li>
    @endforeach
</ul>