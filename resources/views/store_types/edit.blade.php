@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Store Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($storeType, ['route' => ['storeTypes.update', $storeType->id], 'method' => 'patch']) !!}

                        @include('store_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection