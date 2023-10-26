@extends('layouts.dashboard')
@section('isi')
   <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{ url('/rekap-data') }}">
                        <div class="form-row">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableprintrekap" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th>Sudden Leave Total</th>
                                <th>Mass Leave Total</th>
                                <th>Married Leave Total</th>
                                <th>Non-Dependent Leave Total</th>
                                <th>Special Leave Total</th>
                                <th>Maternity leave Total</th>
                                <th>Late Permit Total</th>
                                <th>Go Home Earlier Permit Total</th>
                                <th>Attendance Total</th>
                                <th>Alpha Total</th>
                                <th>Off Total</th>
                                <th>Late Total</th>
                                <th>Go Home Earlier Total</th>
                                <th>Overtime Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_user as $du)
                            <tr>
                                <td>
                                    {{ $du->name }}
                                </td>

                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Dadakan')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Bersama')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Menikah')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Diluar Tanggungan')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Khusus')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Cuti Melahirkan')->where('status_cuti', 'Diterima')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $jumlah_izin_telat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Telat')->count()
                                    @endphp
                                    {{ $jumlah_izin_telat . " x" }}
                                </td>
                                <td>
                                    @php
                                        $jumlah_izin_pulang_cepat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Pulang Cepat')->count()
                                    @endphp
                                    {{ $jumlah_izin_pulang_cepat . " x" }}
                                </td>
                                <td>
                                    @php
                                        $jumlah_hadir = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', '=', 'Masuk')->count();
                                    @endphp
                                    {{ $jumlah_hadir + $jumlah_izin_telat + $jumlah_izin_pulang_cepat. " x" }}
                                </td>
                                <td>
                                    @php
                                        echo $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Tidak Masuk')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        echo $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Libur')->count() . " x";
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $total_telat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('telat');
                                        $jam   = floor($total_telat / (60 * 60));
                                        $menit = $total_telat - ( $jam * (60 * 60) );
                                        $menit2 = floor($menit / 60);
                                    @endphp

                                    @if($jam <= 0 && $menit2 <= 0)
                                        <span class="badge badge-success">Never Be Late</span>
                                    @else
                                        <span class="badge badge-danger">{{ $jam." Jam ".$menit2." Menit" }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $total_pulang_cepat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('pulang_cepat');
                                        $jam_cepat   = floor($total_pulang_cepat / (60 * 60));
                                        $menit_cepat = $total_pulang_cepat - ( $jam_cepat * (60 * 60) );
                                        $menit_cepat2 = floor($menit_cepat / 60);
                                    @endphp

                                    @if($jam_cepat <= 0 && $menit_cepat2 <= 0)
                                        <span class="badge badge-success">Never Go Home Early</span>
                                    @else
                                        <span class="badge badge-danger">{{ $jam_cepat." Jam ".$menit_cepat2." Menit" }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $total_lembur = $du->Lembur->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('total_lembur');
                                        $jam   = floor($total_lembur / (60 * 60));
                                        $menit = $total_lembur - ( $jam * (60 * 60) );
                                        $menit2 = floor($menit / 60);
                                        $detik = $total_lembur % 60;
                                    @endphp

                                    <span class="badge badge-success">{{ $jam." Jam ".$menit2." Menit" }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<br>
@endsection
