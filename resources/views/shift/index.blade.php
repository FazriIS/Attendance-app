@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <center>
                    <a href="{{ url('/shift/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Shift Data</a>
                </center>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tableprint" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Shift Name</th>
                            <th>Attendance Time</th>
                            <th>Out Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shift as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nama_shift }}</td>
                                <td>{{ $s->jam_masuk}}</td>
                                <td>{{ $s->jam_keluar}}</td>
                                <td>
                                    @if($s->nama_shift == 'Libur')
                                        <span class="badge badge-success">Default Shift</span>
                                    @else
                                        <a href="{{ url('/shift/'.$s->id.'/edit') }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                        <form action="{{ url('/shift/'.$s->id) }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <br>
@endsection
