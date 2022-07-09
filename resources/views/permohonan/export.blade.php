<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pemegang</th>
            <th>Jenis</th>
            <th>Pemohon</th>
            <th>Nomor Sertifikat - Desa</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->user->nama }}</td>
                <td>{{ $d->jenis_berkas->deskripsi }}</td>
                <td>{{ $d->pemohon->nama }}</td>
                <td>{{ $d->nomor_sertifikat.' - '.$d->desa }}</td>
                <td>{{ ($d->riwayat_latest->keterangan ?? '') }}</td>
                <td>{{ ($d->riwayat_latest->status_berkas->deskripsi ?? '') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>