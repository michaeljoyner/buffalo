@if($mobileCategoryItems->count() > 0)
<div class="mobile-category-menu">
    <div class="select-container">
        <span class="select-arrow"></span>
        <select name="categories" class="menu-select">
            <option value="" disabled selected>Select a category</option>
            @foreach($mobileCategoryItems as $catItem)
                <option value="{{ $slugBase . $catItem->slug }}">{{ $catItem->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@endif