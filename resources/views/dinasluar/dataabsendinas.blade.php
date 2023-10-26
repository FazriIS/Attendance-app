@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form action="{{ url('/data-dinas-luar') }}">
                            <span>Filter Nama dan Rentang Tanggal</span><br><br>
                            <div class="form-row">
                                <div class="col-3">
                                    <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true">
                                        <option value=""selected>Pilih Pegawai</option>
                                        @foreach($user as $u)
                                            @if(request('user_id') == $u->id)
                                                <option value="{{ $u->id }}"selected>{{ $u->name }}</option>
                                            @else
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai" id="mulai" value="{{ request('mulai') }}">
                                </div>
                                <div class="col-3">
                                    <input type="datetime" class="form-control" name="akhir" placeholder="Tanggal Akhir" id="akhir" value="{{ request('akhir') }}">
                                </div>
                                <div>
                                    <button type="submit" id="search" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tableprintdinas" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Staff Name</th>
                            <th>Shift</th>
                            <th>TDate</th>
                            <th>Attendance Time</th>
                            <th>Late</th>
                            <th>Attendance Location</th>
                            <th>Attendance Photo</th>
                            <th>Go Home Time</th>
                            <th>Go Home Early</th>
                            <th>Go Home Location</th>
                            <th>Go Home Photo</th>
                            <th>Absent Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_absen as $da)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $da->User->name }}</td>
                        <td>{{ $da->Shift->nama_shift }} ({{ $da->Shift->jam_masuk }} - {{ $da->Shift->jam_keluar }})</td>
                        <td>{{ $da->tanggal }}</td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @else
                                {{ $da->jam_absen }}
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->status_absen == 'Izin Telat')
                                <span class="badge badge-warning">Late Permission</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @else
                            <?php
                                $telat = $da->telat;
                                $jam   = floor($telat / (60 * 60));
                                $menit = $telat - ( $jam * (60 * 60) );
                                $menit2 = floor( $menit / 60 );
                                $detik = $telat % 60;
                            ?>
                                @if($jam <= 0 && $menit2 <= 0)
                                    <span class="badge badge-success">On Time</span>
                                @else
                                    <span class="badge badge-danger">{{ $jam." Jam ".$menit2." Menit" }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @else
                                <a href="{{ url('/maps/'.$da->lat_absen.'/'.$da->long_absen.'/'.$da->User->id) }}" class="btn btn-sm btn-secondary" target="_blank">lihat</a>
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @else
                                <img src="{{ url('storage/' . $da->foto_jam_absen) }}" style="width: 60px">
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @elseif($da->jam_pulang == null)
                                <span class="badge badge-warning">Not Yet Home</span>
                            @else
                                {{ $da->jam_pulang }}
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->status_absen == 'Izin Pulang Cepat')
                                <span class="badge badge-warning">Go Home Early Pemisiion</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent yet</span>
                            @elseif($da->jam_pulang == null)
                                <span class="badge badge-warning">Not Yet Home</span>
                            @else
                                <?php
                                    $pulang_cepat = $da->pulang_cepat;

                                    $jam   = floor($pulang_cepat / (60 * 60));
                                    $menit = $pulang_cepat - ( $jam * (60 * 60) );
                                    $menit2 = floor( $menit / 60 );
                                    $detik = $pulang_cepat % 60;
                                ?>
                                 @if($jam <= 0 && $menit2 <= 0)
                                    <span class="badge badge-success">Not Go Home Early</span>
                                 @else
                                    <span class="badge badge-danger">{{ $jam." Jam ".$menit2." Menit" }}</span>
                                 @endif
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @elseif($da->jam_pulang == null)
                                <span class="badge badge-warning">Not Go Home</span>
                            @else
                                <a href="{{ url('/maps/'.$da->lat_pulang.'/'.$da->long_pulang.'/'.$da->User->id) }}" class="btn btn-sm btn-secondary" target="_blank">lihat</a>
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">Holiday</span>
                            @elseif($da->status_absen == 'Cuti')
                                <span class="badge badge-warning">On Leave</span>
                            @elseif($da->jam_absen == null)
                                <span class="badge badge-danger">Not Absent Yet</span>
                            @elseif($da->jam_pulang == null)
                                <span class="badge badge-warning">Not Go Home</span>
                            @else
                                <img src="{{ url('storage/' . $da->foto_jam_pulang) }}" style="width: 60px">
                            @endif
                        </td>
                        <td>
                            @if($da->status_absen == 'Libur')
                                <span class="badge badge-info">{{ $da->status_absen }}</span>
                            @elseif($da->status_absen == 'Cuti' || $da->status_absen == 'Izin Telat' || $da->status_absen == 'Izin Pulang Cepat')
                                <span class="badge badge-warning">{{ $da->status_absen }}</span>
                            @elseif($da->status_absen == 'Masuk')
                                <span class="badge badge-success">{{ $da->status_absen }}</span>
                            @else
                                <span class="badge badge-danger">{{ $da->status_absen }}</span>
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
