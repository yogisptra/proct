<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
</head>

<body>

    <h2>HTML Table</h2>
    @if(Session::has('success'))
    <div role="alert">
        <i> {{Session::get('success')}} </i>
    </div>
    @elseif((Session::has('error')))
    <div role="alert">
        <i> {{Session::get('error')}} </i>
    </div>
    @endif
    <a href="{{route('admin.create')}}">Tambah Data</a>

	@if(count($datas) > 0)
    <table>
        <tr>
            <th>Nama</th>
			<th>Image</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
		@php
        $i = 1;
        @endphp
        @foreach($datas as $row)
			<tr>
				<td>{{$row->name}}</td>
				<td><img src="{{asset('assets/images/admin/'. $row->image)}}" width="100px" height="auto"></td>
				<td>{{$row->email}}</td>
				<td>{{$row->phone_number}}</td>
				<td>{{$row->enabled}}</td>
				<td>
				<a href="{{route('admin.edit', $row->id)}}">Edit</a>
				 | 
				<a href="{{route('admin.destroy', $row->id)}}">Delete</a>
				</td>
			</tr>
		@endforeach
    </table>
	@else
		<h2>Data Kosong</h2>
	@endif

</body>

</html>