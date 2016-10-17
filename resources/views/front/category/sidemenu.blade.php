<ul class="first-level">
    @foreach($category->subcategories as $identifier => $cat_subcategory)
        <li @if(isset($subcategory))
                @if($subcategory->name === $cat_subcategory->name) class="current-sub" @endif
        @endif
        @if(isset($productGroup))
            @if($productGroup->subcategory->id === $cat_subcategory->id) class="current-sub" @endif
            @endif>
            <a href="/subcategories/{{ $cat_subcategory->slug }}">{{ $cat_subcategory->name }}</a>
            @if($cat_subcategory->productGroups->count() > 0)
                <label class="menu-trigger-label" for="menu-trigger-{{ $identifier }}">
                    @include('svgicons.down_arrow3')
                </label>
                <input type="checkbox" class="menu-trigger" id="menu-trigger-{{ $identifier }}">
                <ul class="second-level">
                    @foreach($cat_subcategory->productGroups as $cat_productGroup)
                        <li><a href="/productgroups/{{ $cat_productGroup->slug }}">{{ $cat_productGroup->name }}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>