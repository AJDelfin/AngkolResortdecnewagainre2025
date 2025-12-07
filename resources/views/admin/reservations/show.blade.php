@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Reservation Details</h1>
        <table class="table">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $reservation->id }}</td>
                </tr>
                <tr>
                    <th>Guest</th>
                    <td>{{ $reservation->user->name }}</td>
                </tr>
                <tr>
                    <th>Accommodation</th>
                    <td>
                        @if ($reservation->room)
                            Room: {{ $reservation->room->room_number }}
                        @elseif ($reservation->cottage)
                            Cottage: {{ $reservation->cottage->name }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Check-in Date</th>
                    <td>{{ $reservation->check_in_date->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Check-out Date</th>
                    <td>{{ $reservation->check_out_date->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Number of Guests</th>
                    <td>{{ $reservation->number_of_guests }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>{{ $reservation->total_price }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $reservation->status }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
