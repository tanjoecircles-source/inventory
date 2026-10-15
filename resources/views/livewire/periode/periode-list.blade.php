<div>
    <div class="card text-center no-border shadow-none custom-square mb-2">
        <div class="card-body px-2 py-0">
            <div class="input-group mb-2">
                <input type="text" wire:model.live.debounce.400ms="keyword" class="form-control br-tl-7 br-bl-7" placeholder="Type Keyword...">
                <div class="input-group-append">
                    <span class="btn btn-primary br-tr-7 br-br-7">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-center no-border shadow-none custom-square">
        <div class="card-body p-0">
            <div id="content-data">
                @if($contents_count == 0)
                    <h6 class="m-4">No matching records found</h6>
                @endif
                @foreach ($contents as $content)
                    <div class="d-flex p-4 border-bottom" wire:key="periode-{{ $content->id }}">
                        <i class="fe fe-calendar my-1 fs-16 mr-2"></i>
                        <div class="my-1 text-left">
                            <h6 class="mb-0 font-weight-semibold">{{ $content->name }}</h6>
                            <span class="fs-13 text-muted">{{ !empty($content->start_date) ? date('d M Y', strtotime($content->start_date)) : '-' }} - {{ !empty($content->end_date) ? date('d M Y', strtotime($content->end_date)) : '-' }}</span>
                        </div>
                        <div class="ml-auto my-1">
                            <a href="{{ url('periode-edit/'.$content->id) }}" wire:navigate class="btn btn-sm btn-dark mr-1">
                                <i class="fe fe-edit-2"></i>
                            </a>
                            <button type="button" wire:click="delete({{ $content->id }})" wire:confirm="Yakin ingin menghapus periode {{ $content->name }}?" class="btn btn-sm btn-danger">
                                <i class="fe fe-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($hasMore)
                <div class="p-3">
                    <button type="button" wire:click="loadMore" wire:loading.attr="disabled" class="btn btn-outline-primary btn-block">
                        <span wire:loading.remove wire:target="loadMore">Muat lebih banyak</span>
                        <span wire:loading wire:target="loadMore"><i class="fa fa-circle-o-notch fa-spin"></i> Memuat...</span>
                    </button>
                </div>
            @endif
            <div wire:loading.flex class="justify-content-center p-3 text-muted">
                <span><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</span>
            </div>
        </div>
    </div>
</div>
