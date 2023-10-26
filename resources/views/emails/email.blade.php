@component('mail::message')
# Dear {{ $data->User->name }}

Document Validity Period {{ $data->nama_dokumen }} Will be out of date {{ $data->tanggal_berakhir }}, Update Soon.

Thanks,<br>
<h1 style="color: green">GPI<sup>Click</sup></h1>
@endcomponent
