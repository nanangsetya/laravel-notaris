<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Bayar</th>
            <th>Staff</th>
            <th>Nomor Sertifikat</th>
            <th>Jenis Permohonan</th>
            <th>Nama Pemohon</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->permohonan->user->nama }}</td>
                <td>{{ $d->permohonan->nomor_sertifikat }}</td>
                <td>{{ $d->permohonan->jenis_berkas->deskripsi }}</td>
                <td>{{ $d->permohonan->pemohon->nama }}</td>
                <td align="right">{{ rupiah($d->nominal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
