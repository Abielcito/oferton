<table class="table table-responsive" id="storeCategories-table">
    <thead>
        <tr>
            <th>Find By Link</th>
        <th>Json Detail</th>
        <th>Store Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($storeCategories as $storeCategory)
        <tr>
            <td>{!! $storeCategory->find_by_link !!}</td>
            <td>{!! $storeCategory->json_detail !!}</td>
            <td>{!! $storeCategory->store_id !!}</td>
            <td>
                {!! Form::open(['route' => ['storeCategories.destroy', $storeCategory->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('storeCategories.show', [$storeCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('storeCategories.edit', [$storeCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>