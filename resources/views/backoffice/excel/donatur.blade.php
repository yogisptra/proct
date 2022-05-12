<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Donatur</th>
            <th>Email Donatur</th>
            <th>Nomor Telepon Donatur</th>
            <th>Nominal</th>
            <th>Kode Unik</th>
            <th>Tanggal Transaksi</th>
            <th>Tanggal Pembayaran</th>
            <th>Metode Pembayaran</th>
            <th>Status Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i= 1;
        @endphp
        @foreach($data as $row)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->phone_number }}</td>
            <td>{{ $row->amount }}</td>
            <td>{{ $row->unique_code }}</td>
            <td>{{ $row->transaction_date }}</td>
            <td>{{ $row->payment_date }}</td>
            <td>{{ $row->payment_method }}</td>
            <td>{{ $row->transaction_status_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
