@extends('admin.base')

@section('content')
    <search-view search-url="/admin/api/products/search"
                 page-size="20"
                 initial-query="{{ $query }}"
    >
        <stat-counter :upper-val="{{ $stats->products }}"
                      :step="20"
                      stat-title="Products"
        ></stat-counter>
        <stat-counter :upper-val="{{ $stats->categories }}"
                      :step="1"
                      stat-title="Categories"
        ></stat-counter>
        <stat-counter :upper-val="{{ $stats->subcategories }}"
                      :step="2"
                      stat-title="SubCategories"
        ></stat-counter>
        <stat-counter :upper-val="{{ $stats->productGroups }}"
                      :step="2"
                      stat-title="Product Groups"
        ></stat-counter>
    </search-view>


@endsection