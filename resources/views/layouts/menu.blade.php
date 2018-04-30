<li class="{{ Request::is('stores*') ? 'active' : '' }}">
    <a href="{!! route('stores.index') !!}"><i class="fa fa-edit"></i><span>Stores</span></a>
</li>

<li class="{{ Request::is('storeCategories*') ? 'active' : '' }}">
    <a href="{!! route('storeCategories.index') !!}"><i class="fa fa-edit"></i><span>Store Categories</span></a>
</li>

<li class="{{ Request::is('storeTypes*') ? 'active' : '' }}">
    <a href="{!! route('storeTypes.index') !!}"><i class="fa fa-edit"></i><span>Store Types</span></a>
</li>

