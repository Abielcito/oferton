<table class="table table-responsive" id="storesTypes-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($storesTypes as $storesTypes)
        <tr>
            <td>{!! $storesTypes->name !!}</td>
            <td>{!! $storesTypes->status !!}</td>
            <td>
                {!! Form::open(['route' => ['storesTypes.destroy', $storesTypes->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('storesTypes.show', [$storesTypes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('storesTypes.edit', [$storesTypes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>