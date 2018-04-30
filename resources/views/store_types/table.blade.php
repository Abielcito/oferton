<table class="table table-responsive" id="storeTypes-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($storeTypes as $storeType)
        <tr>
            <td>{!! $storeType->name !!}</td>
            <td>{!! $storeType->status !!}</td>
            <td>
                {!! Form::open(['route' => ['storeTypes.destroy', $storeType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('storeTypes.show', [$storeType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('storeTypes.edit', [$storeType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>