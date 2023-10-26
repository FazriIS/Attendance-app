@extends('layouts.dashboard')
@section('isi')
    @if($dinas_luar->count() > 0)
        @foreach ($dinas_luar as $dl)
            <?php $dlid = $dl->id ?>
            <?php $dltanggal = $dl->tanggal ?>
            <?php $dlnamas = $dl->Shift->nama_shift  ?>
            <?php $dljamas = $dl->Shift->jam_masuk ?>
            <?php $dljamkel = $dl->Shift->jam_keluar ?>
            <?php $dljamab = $dl->jam_absen ?>
            <?php $dljampul = $dl->jam_pulang ?>
            <?php $dlstatus = $dl->status_absen ?>

        @endforeach
    @else
        <?php $dlid = "-" ?>
        <?php $dltanggal = "-" ?>
        <?php $dlnamas = "-"  ?>
        <?php $dljamas = "-" ?>
        <?php $dljamkel = "-" ?>
        <?php $dljamab = "-" ?>
        <?php $dljampul = "-" ?>
        <?php $dlstatus = "-" ?>
    @endif
    <div class="container-fluid">
        <center style="color: white">
            <p class="p mb-2 text-gray-800">Shift Date : {{ $dltanggal }}</p>
            <p class="p mb-2 text-gray-800">Shift : {{ $dlnamas}} ({{ $dljamas }} - {{  $dljamkel }})</p>
        </center>

        <style>
            h1,
            h2,
            p,
            a {
              font-family: sans-serif;
              font-weight: 8;
            }

            .jam-digital-malasngoding {
              overflow: hidden;
              float: center;
              width: 100px;
              margin: 2px auto;
              border: 0px solid #efefef;
            }

            .kotak {
              float: left;
              width: 30px;
              height: 30px;
              background-color: #189fff;
            }

            .jam-digital-malasngoding p {
              color: #fff;
              font-size: 16px;
              text-align: center;
              margin-top: 3px;
            }
        </style>

        <div class="jam-digital-malasngoding">
            <div class="kotak">
              <p id="jam"></p>
            </div>
            <div class="kotak">
              <p id="menit"></p>
            </div>
            <div class="kotak">
              <p id="detik"></p>
            </div>
        </div>

        <script>
            window.setTimeout("waktu()", 1000);

            function waktu() {
              var waktu = new Date();
              setTimeout("waktu()", 1000);
              document.getElementById("jam").innerHTML = waktu.getHours();
              document.getElementById("menit").innerHTML = waktu.getMinutes();
              document.getElementById("detik").innerHTML = waktu.getSeconds();
            }
        </script>
        <br>

        <div class="d-flex justify-content-center">
            <form action="{{ url('/my-location') }}" method="get">
                @csrf
                <input type="hidden" name="lat" id="lat2">
                <input type="hidden" name="long" id="long2">
                <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
                <button type="submit" class="btn btn-success">See My Location</button>
            </form>
        </div>

        @if($dinas_luar->count() == 0)
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
                <center>
                    <h2>Contact Admin to Mapping Your Shift</h2>
                </center>
            </div>
        </div>
        </div>
        @elseif($dlstatus == "Libur")
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
                <center>
                    <h2>Today you are off</h2>
                </center>
            </div>
        </div>
        </div>
        @elseif($dlstatus == "Cuti")
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
            <center>
                <h2>Today you are on leave</h2>
            </center>
            </div>
        </div>
        </div>
        @else
            @if($dljamab == null)
            <br>
                <div class="card col-lg-12">
                    <div class="mt-4">
                        <form method="post" action="{{ url('/dinas-luar/masuk/'.$dlid) }}">
                            @method('put')
                            @csrf
                            <div class="form-row">
                                <div class="col"></div>
                                <div class="col">
                                    <center>
                                        <h2>Enter the External Service : </h2>
                                        <div class="webcam" id="results"></div>
                                    </center>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="jam_absen">
                                    <input type="hidden" name="foto_jam_absen" class="image-tag">
                                    <input type="hidden" name="lat_absen" id="lat">
                                    <input type="hidden" name="long_absen" id="long">
                                    <input type="hidden" name="telat">
                                    <input type="hidden" name="status_absen">
                                </div>
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary" value="Ambil Foto" onClick="take_snapshot()">Submit</button>
                            </center>
                            </form>
                            <br>
                    </div>
                </div>
                <br><br>

                <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
                <script language="JavaScript">
                Webcam.set({
                    width: 240,
                    height: 320,
                    image_format: 'jpeg',
                    jpeg_quality: 50
                });
                Webcam.attach( '.webcam' );
                </script>
                <script language="JavaScript">
                function take_snapshot() {
                    // take snapshot and get image data
                    Webcam.snap( function(data_uri) {
                            $(".image-tag").val(data_uri);
                    // display results in page
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                    } );
                }
                </script>

            @elseif($dljampul == null)
            <br>
            <div class="card col-lg-12">
                <div class="mt-4">
                    <form method="post" action="{{ url('/dinas-luar/pulang/'.$dlid) }}">
                        @method('put')
                        @csrf
                        <div class="form-row">
                            <div class="col"></div>
                            <div class="col">
                                <center>
                                    <h2>Returning from overseas service: </h2>
                                    <div class="webcam" id="results"></div>
                                </center>
                            </div>
                            <div class="col">
                                <input type="hidden" name="jam_pulang">
                                <input type="hidden" name="foto_jam_pulang" class="image-tag">
                                <input type="hidden" name="lat_pulang" id="lat">
                                <input type="hidden" name="long_pulang" id="long">
                                <input type="hidden" name="pulang_cepat">
                            </div>
                        </div>
                        <br>
                        <center>
                            <button type="submit" class="btn btn-primary" value="Ambil Foto" onClick="take_snapshot()">Go home</button>
                        </center>
                    </form>
                    <br>
                </div>
            </div>
            <br><br>

            <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
            <script language="JavaScript">
            Webcam.set({
                width: 240,
                height: 320,
                image_format: 'jpeg',
                jpeg_quality: 50
            });
            Webcam.attach( '.webcam' );
            </script>
            <script language="JavaScript">
            function take_snapshot() {
                // take snapshot and get image data
                Webcam.snap( function(data_uri) {
                        $(".image-tag").val(data_uri);
                // display results in page
                document.getElementById('results').innerHTML =
                    '<img src="'+data_uri+'"/>';
                } );
            }
            </script>

            @else
            <br>
            <div class="card col-lg-12">
                <div class="mt-5">
                <div class="mb-5">
                    <center>
                        <h2>Your Absent Is Finish</h2>
                    </center>
                </div>
                </div>
            </div>

            @endif
        @endif


    </div>
    <br>
@endsection
