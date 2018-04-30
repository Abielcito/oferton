@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Stores Types
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($storesTypes, ['route' => ['storesTypes.update', $storesTypes->id], 'method' => 'patch']) !!}

                        @include('stores_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection