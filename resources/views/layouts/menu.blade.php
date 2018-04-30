


<li class="{{ Request::is('stores*') ? 'active' : '' }}">
    <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>Stores</span></a>
</li>

<li class="{{ Request::is('storesTypes*') ? 'active' : '' }}">
    <a href="{!! route('storesTypes.index') !!}"><i class="fa fa-edit"></i><span>Stores Types</span></a>
</li>

<li class="{{ Request::is('storeCategories*') ? 'active' : '' }}">
    <a href="{!! route('storeCategories.index') !!}"><i class="fa fa-edit"></i><span>Store Categories</span></a>
</li>

