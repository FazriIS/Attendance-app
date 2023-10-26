<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @if(auth()->user()->is_admin == 'admin')
        <a href="{{ url('/dashboard') }}" class="brand-link">
    @else
        <a href="{{ url('/absen') }}" class="brand-link">
    @endif
        <img src="{{ url('assets/img/absensi.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Online AbsentO</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex {{ Request::is('my-profile*') ? 'btn btn-primary' : '' }}">
            <div class="image">
                @if(auth()->user()->foto_karyawan == null)
                    <img src="{{ url('assets/img/foto_default.jpg') }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ url('storage/'.auth()->user()->foto_karyawan) }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ url('/my-profile') }}" class="d-block" style="{{ Request::is('my-profile*') ? 'color: white' : '' }}">My Profile</a>
            </div>
        </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->

            <hr style="background-color:dimgray">

        @can('admin')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">DATA MASTER</li>
                        <li class="nav-item">
                            <a href="{{ url('/pegawai') }}" class="nav-link {{ Request::is('pegawai*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-solid fa-user"></i>
                                <p>
                                    Staff
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/shift') }}" class="nav-link {{ Request::is('shift*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-fw fa-clock"></i>
                                <p>
                                    Master Shift
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/rekap-data') }}" class="nav-link {{ Request::is('rekap-data*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-database"></i>
                                <p>
                                    Recap of Attendance Data
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/lokasi-kantor') }}" class="nav-link {{ Request::is('lokasi-kantor*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-map-marked-alt"></i>
                                <p>
                                    Location Master
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/reset-cuti') }}" class="nav-link {{ Request::is('reset-cuti*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-sync-alt"></i>
                                <p>
                                    Leave Reset
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/auto-shift') }}" class="nav-link {{ Request::is('auto-shift*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-robot"></i>
                                <p>
                                    Auto Shift
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/jabatan') }}" class="nav-link {{ Request::is('jabatan*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-universal-access"></i>
                                <p>
                                    Postition Master
                                </p>
                            </a>
                        </li>
                </ul>
            </nav>

            <hr style="background-color:dimgray">
        @endcan



        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">ABSENT</li>
                <li class="nav-item">
                    <a href="{{ url('/absen') }}" class="nav-link {{ Request::is('absen*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-stopwatch"></i>
                        <p>
                            Absent
                        </p>
                    </a>
                </li>
                @can('admin')
                    <li class="nav-item">
                        <a href="{{ url('/data-absen') }}" class="nav-link {{ Request::is('data-absen*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-solid fa-table"></i>
                            <p>
                                Absent Data
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ url('/my-absen') }}" class="nav-link {{ Request::is('my-absen*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user-secret"></i>
                        <p>
                            My Absent
                        </p>
                    </a>
                </li>

            </ul>
        </nav>

        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Outside Office Service</li>
                <li class="nav-item">
                    <a href="{{ url('/dinas-luar') }}" class="nav-link {{ Request::is('dinas-luar*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-stopwatch"></i>
                        <p>
                            Absence from External Service
                        </p>
                    </a>
                </li>
                @can('admin')
                    <li class="nav-item">
                        <a href="{{ url('/data-dinas-luar') }}" class="nav-link {{ Request::is('data-dinas-luar*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-solid fa-table"></i>
                            <p>
                                External Service Data
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ url('/my-dinas-luar') }}" class="nav-link {{ Request::is('my-dinas-luar*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user-secret"></i>
                        <p>
                            My External Service
                        </p>
                    </a>
                </li>

            </ul>
        </nav>

        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">OVERTIME</li>
                <li class="nav-item">
                    <a href="{{ url('/lembur') }}" class="nav-link {{ Request::is('lembur*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-fw fa-user-clock"></i>
                        <p>
                            Overtime
                        </p>
                    </a>
                </li>
                @can('admin')
                    <li class="nav-item">
                        <a href="{{ url('/data-lembur') }}" class="nav-link {{ Request::is('data-lembur*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-solid fa-table"></i>
                            <p>
                                Overtime Data
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ url('/my-lembur') }}" class="nav-link {{ Request::is('my-lembur*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-business-time"></i>
                        <p>
                            My Overtime
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">LEAVE</li>
                <li class="nav-item">
                    <a href="{{ url('/cuti') }}" class="nav-link {{ Request::is('cuti*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-hourglass-half"></i>
                        <p>
                            Leave Permition
                        </p>
                    </a>
                </li>

                @can('admin')
                    <li class="nav-item">
                        <a href="{{ url('/data-cuti') }}" class="nav-link {{ Request::is('data-cuti*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-table"></i>
                            <p>
                                Leave Data
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>

        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Docs</li>

                @can('admin')
                    <li class="nav-item">
                        <a href="{{ url('/dokumen') }}" class="nav-link {{ Request::is('dokumen*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-folder-open"></i>
                            <p>
                                Staff Document
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ url('/my-dokumen') }}" class="nav-link {{ Request::is('my-dokumen*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-folder"></i>
                        <p>
                            My Document
                        </p>
                    </a>
                </li>


            </ul>
        </nav>


        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">REQUEST</li>

                <li class="nav-item">
                    <a href="{{ url('/request-location') }}" class="nav-link {{ Request::is('request-location*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-holly-berry"></i>
                        <p>
                            Location Request
                        </p>
                    </a>
                </li>

            </ul>
        </nav>

        <hr style="background-color:dimgray">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Log Out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
