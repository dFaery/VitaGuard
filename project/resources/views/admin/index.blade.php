@extends('layouts.navbar.admin')
@section('content')
@php($i = 1)
<div class="container">
    @foreach ($dataTables as $tableName => $rows)
    <div class="row">
        <div class="col-6 mb-4">
            <h5>TABLE {{ $loop->iteration }}. {{ $tableName }}</h5>
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            @if(count($rows) > 0)
                            @foreach(array_keys($rows[0]->toArray()) as $column)
                            <th>{{ $column }}</th>
                            @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                        <tr>
                            @foreach ($row->toArray() as $value)
                            <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection