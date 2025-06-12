@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Database Viewer</h4>
                    <small class="text-muted">Database: {{ config('database.connections.sqlite.database') }}</small>
                </div>

                <div class="card-body">
                    @if(isset($error))
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ $error }}
                        </div>
                    @endif

                    @if(empty($tableData))
                        <div class="alert alert-warning">
                            <strong>No tables found!</strong> 
                            <p>Try running: <code>php artisan migrate</code></p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($tableData as $table)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="mb-0">{{ $table['name'] }}</h5>
                                            <span class="badge badge-primary">{{ $table['count'] }} rows</span>
                                        </div>
                                        <div class="card-body">
                                            <h6>Columns:</h6>
                                            <ul class="list-unstyled">
                                                @foreach($table['columns'] as $column)
                                                    <li>
                                                        <code>{{ $column->name }}</code> 
                                                        <small class="text-muted">({{ $column->type }})</small>
                                                        @if($column->pk) <span class="badge badge-warning">PK</span> @endif
                                                        @if($column->notnull) <span class="badge badge-info">NOT NULL</span> @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                            
                                            @if($table['count'] > 0)
                                                <a href="{{ route('database.table', $table['name']) }}" class="btn btn-sm btn-outline-primary">
                                                    View Data
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
