@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form action="{{ url('/data-absen') }}">
                    <span>Name & Date Filter</span><br><br>
                    <div class="form-row">
                        <div class="col-3">
                            <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true">
                                <option value=""selected>Select Staff</option>
                                @foreach ($user as $u)
                                    @if (request('user_id') == $u->id)
                                        <option value="{{ $u->id }}"selected>{{ $u->name }}</option>
                                    @else
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai"
                                id="mulai" value="{{ request('mulai') }}">
                        </div>
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="akhir" placeholder="Tanggal Akhir"
                                id="akhir" value="{{ request('akhir') }}">
                        </div>
                        <div>
                            <button type="submit" id="search" class="form-control btn btn-primary"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tableprintabsen" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Staff Name</th>
                            <th>Shift</th>
                            <th>Date</th>
                            <th>Attendance Time</th>
                            <th>Late</th>
                            <th>Attendance Location</th>
                            <th>Attendance Photo</th>
                            <th>Home Time</th>
                            <th>Go Home Early</th>
                            <th>Home Location</th>
                            <th>Going Home Absent</th>
                            <th>Absent Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_absen as $da)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $da->User->name }}</td>
                                <td>{{ $da->Shift->nama_shift }} ({{ $da->Shift->jam_masuk }} -
                                    {{ $da->Shift->jam_keluar }})</td>
                                <td>{{ $da->tanggal }}</td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Yet Absent</span>
                                    @else
                                        {{ $da->jam_absen }}
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->status_absen == 'Izin Telat')
                                        <span class="badge badge-warning">Late Permission</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Yet Absent</span>
                                    @else
                                        <?php
                                        $telat = $da->telat;
                                        $jam = floor($telat / (60 * 60));
                                        $menit = $telat - $jam * (60 * 60);
                                        $menit2 = floor($menit / 60);
                                        $detik = $telat % 60;
                                        ?>
                                        @if ($jam <= 0 && $menit2 <= 0)
                                            <span class="badge badge-success">On Time</span>
                                        @else
                                            <span
                                                class="badge badge-danger">{{ $jam . ' Jam ' . $menit2 . ' Menit' }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Absent yet</span>
                                    @else
                                        @php
                                            $jarak_masuk = explode('.', $da->jarak_masuk);
                                        @endphp
                                        <a href="{{ url('/maps/' . $da->lat_absen . '/' . $da->long_absen . '/' . $da->User->id) }}"
                                            class="btn btn-sm btn-secondary" target="_blank">lihat</a>
                                        <span class="badge badge-warning">{{ $jarak_masuk[0] }} Meter</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
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
                                    @if ($da->status_absen == 'Libur')
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
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->status_absen == 'Izin Pulang Cepat')
                                        <span class="badge badge-warning">Go Home Early Permission</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Absent Yet</span>
                                    @elseif($da->jam_pulang == null)
                                        <span class="badge badge-warning">No Home Yet</span>
                                    @else
                                        <?php
                                        $pulang_cepat = $da->pulang_cepat;
                                        
                                        $jam = floor($pulang_cepat / (60 * 60));
                                        $menit = $pulang_cepat - $jam * (60 * 60);
                                        $menit2 = floor($menit / 60);
                                        $detik = $pulang_cepat % 60;
                                        ?>
                                        @if ($jam <= 0 && $menit2 <= 0)
                                            <span class="badge badge-success">Not Coming Home Soon</span>
                                        @else
                                            <span
                                                class="badge badge-danger">{{ $jam . ' Jam ' . $menit2 . ' Menit' }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Absent Yet</span>
                                    @elseif($da->jam_pulang == null)
                                        <span class="badge badge-warning">Not Home Yet</span>
                                    @else
                                        @php
                                            $jarak_pulang = explode('.', $da->jarak_pulang);
                                        @endphp
                                        <a href="{{ url('/maps/' . $da->lat_pulang . '/' . $da->long_pulang . '/' . $da->User->id) }}"
                                            class="btn btn-sm btn-secondary" target="_blank">lihat</a>
                                        <span class="badge badge-warning">{{ $jarak_pulang[0] }} Meter</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Absent yet</span>
                                    @elseif($da->jam_pulang == null)
                                        <span class="badge badge-warning">Not Home Yet</span>
                                    @else
                                        <img src="{{ url('storage/' . $da->foto_jam_pulang) }}" style="width: 60px">
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">{{ $da->status_absen }}</span>
                                    @elseif($da->status_absen == 'Cuti' || $da->status_absen == 'Izin Telat' || $da->status_absen == 'Izin Pulang Cepat')
                                        <span class="badge badge-warning">{{ $da->status_absen }}</span>
                                    @elseif($da->status_absen == 'Masuk')
                                        <span class="badge badge-success">{{ $da->status_absen }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $da->status_absen }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @else
                                        <a href="{{ url('/data-absen/' . $da->id . '/edit-masuk') }}"
                                            class="btn btn-warning">Attendance Edit</a>
                                    @endif

                                    @if ($da->status_absen == 'Libur')
                                        <span class="badge badge-info">Holiday</span>
                                    @elseif($da->status_absen == 'Cuti')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($da->jam_absen == null)
                                        <span class="badge badge-danger">Not Attendance</span>
                                    @else
                                        <a href="{{ url('/data-absen/' . $da->id . '/edit-pulang') }}"
                                            class="btn btn-warning">Go Home Edit</a>
                                    @endif

                                    <form action="{{ url('/data-absen/' . $da->id . '/delete') }}" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $da->user_id }}">
                                        <button class="btn btn-danger" onClick="return confirm('Are You Sure')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
