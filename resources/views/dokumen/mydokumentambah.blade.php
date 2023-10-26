@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-4">
                    <form method="post" action="{{ url('/my-dokumen/tambah-proses') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="form-group">
                                <label for="nama_dokumen" class="float-left">Document Name</label>
                                <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen') }}" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen">
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_berakhir" class="float-left">Upload Date</label>
                                <input type="datetime" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" autofocus value="{{ old('tanggal_berakhir') }}">
                                @error('tanggal_berakhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file" class="float-left">Document</label>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
                                <span class="float-left font-italic form-control-sm">Allowed files are doc, docx, pdf, xls, xlsx, ppt, pptx and Max Size 10 MB</span>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                </div>
            </div>
        </center>
    </div>
    <br>
@endsection
