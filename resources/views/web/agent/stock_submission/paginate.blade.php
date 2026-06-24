@foreach ($submissions as $submission)
<a href="{{ route('stock-submission-detail', ['app_id' => $submission->id]) }}" class="text-decoration-none">
    <div class="card mb-3">
        <div class="card-body p-2 row">
            <div class="col-12 px-4">
                <div class="d-flex" style="vertical-align:middle">
                    <h5 class="mb-0 font-weight-semibold fs-16 mr-2">{{ date('d M Y', strtotime($submission->date)) }}</h5>
                    @php
                        $badgeClass = '';
                        switch($submission->status) {
                            case 'Draft':
                                $badgeClass = 'badge-secondary';
                                break;
                            case 'Menunggu Persetujuan':
                                $badgeClass = 'badge-warning';
                                break;
                            case 'Disetujui':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Ditolak':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-secondary';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }} m-0 ml-auto px-2 py-1 fs-10" style="border-radius:4px">{{ $submission->status }}</span>
                </div>
                <label class="text-default p-0 mb-0 d-block mt-1 fs-14 h-40">{{ $submission->type }}</label>
                <div class="d-flex justify-content-between">
                    <div class="text-muted m-0 fs-11" style="line-height:15px">Item : {{ $submission->items_count }}</div>
                    <div class="text-muted m-0 fs-11" style="line-height:15px">Author :{{ $submission->author }}</div>
                </div>
            </div>
        </div>
    </div>
</a>
@endforeach