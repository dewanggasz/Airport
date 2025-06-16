{{-- File ini hanya berisi tabel dan paginasi untuk dimuat ulang oleh AJAX --}}
<div class="schedule-table-wrapper">
    <table class="schedule-table">
        <thead>
            <tr>
                <th>{{ __('table_time') }}</th>
                <th>{{ $direction === 'departure' ? __('table_destination') : __('table_origin') }}</th>
                <th>{{ __('table_airline') }}</th>
                <th>{{ __('table_flight_no') }}</th>
                <th>{{ __('table_status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flights as $flight)
            <tr>
                <td data-label="{{ __('table_time') }}">{{ $flight->scheduled_time->format('H:i') }}</td>
                <td data-label="{{ $direction === 'departure' ? __('table_destination') : __('table_origin') }}">{{ $flight->city }}</td>
                <td data-label="{{ __('table_airline') }}">
                    <div class="airline-info">
                        @if($flight->airline->logo)
                            <img src="{{ Storage::url($flight->airline->logo) }}" alt="Logo {{ $flight->airline->name }}">
                        @endif
                        <span>{{ $flight->airline->name }}</span>
                    </div>
                </td>
                <td data-label="{{ __('table_flight_no') }}">{{ $flight->flight_number }}</td>
                <td data-label="{{ __('table_status') }}">
                    @php
                        $statusClass = str_replace(' ', '-', strtolower($flight->status));
                    @endphp
                    <span class="status-badge status-badge--{{ $statusClass }}">
                        {{ $flight->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">{{ __('table_no_data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-container">
    {{ $flights->withQueryString()->links('vendor.pagination.custom-pagination') }}
</div>
