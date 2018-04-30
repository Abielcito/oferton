<!-- Find By Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('find_by_link', 'Find By Link:') !!}
    {!! Form::text('find_by_link', null, ['class' => 'form-control']) !!}
</div>

<!-- Json Detail Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('json_detail', 'Json Detail:') !!}
    {!! Form::textarea('json_detail', null, ['class' => 'form-control']) !!}
</div>

<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('store_id', 'Store Id:') !!}
    {!! Form::number('store_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('storeCategories.index') !!}" class="btn btn-default">Cancel</a>
</div>
