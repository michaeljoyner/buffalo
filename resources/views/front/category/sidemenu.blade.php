<ul class="first-level">
    @foreach($category->subcategories as $index => $subcategory)
        <li>
            <a href="/subcategories/{{ $subcategory->slug }}">{{ $subcategory->name }}</a>
            @if($subcategory->productGroups->count() > 0)
                <label class="menu-trigger-label" for="menu-trigger-{{ $index }}">&dArr;</label>
                <input type="checkbox" class="menu-trigger" id="menu-trigger-{{ $index }}">
                <ul class="second-level">
                    @foreach($subcategory->productGroups as $productGroup)
                        <li><a href="/productgroups/{{ $productGroup->slug }}">{{ $productGroup->name }}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>