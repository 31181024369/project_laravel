<li>
    <a href="{{route('cat', Str::slug($child_category->name))}}" title="">{{ $child_category->name }}</a>
    @if ($child_category->categories->count()>0)
            @foreach ($child_category->categories as $childCategory)
                <ul class="sub-menu">
                    @include('layouts.child_category', ['child_category' => $childCategory])
                </ul>
            @endforeach
    @endif
</li>
