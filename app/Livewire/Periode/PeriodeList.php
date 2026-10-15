<?php

namespace App\Livewire\Periode;

use App\Models\Periode;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PeriodeList extends Component
{
    public string $keyword = '';

    public int $perPage = 10;

    public int $limitStep = 10;

    protected $listeners = [
        'periode-saved' => '$refresh',
    ];

    public function mount(string $keyword = ''): void
    {
        $this->keyword = $keyword;
    }

    public function updatedKeyword(): void
    {
        $this->resetPageData();
    }

    public function loadMore(): void
    {
        $this->perPage += $this->limitStep;
    }

    public function delete(int $id): void
    {
        $data = Periode::find($id);
        if (is_null($data)) {
            $this->dispatch('periode-notify', type: 'error', message: 'Something Wrong, data not found.');
            return;
        }
        if (!$data->delete()) {
            $this->dispatch('periode-notify', type: 'error', message: 'Something Wrong, Data failed to delete.');
            return;
        }
        $this->resetPageData();
        $this->dispatch('periode-notify', type: 'success', message: 'Data has been deleted.');
    }

    protected function resetPageData(): void
    {
        $this->perPage = $this->limitStep;
    }

    public function render()
    {
        $search = trim($this->keyword);

        $query = DB::table('periode')
            ->select('*')
            ->whereRaw('1 = 1')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'DESC');

        $total = (clone $query)->count();
        $contents = $query->limit($this->perPage + 1)->get();

        $hasMore = $contents->count() > $this->perPage;
        $contents = $contents->take($this->perPage);

        return view('livewire.periode.periode-list', [
            'contents' => $contents,
            'contents_count' => $total,
            'hasMore' => $hasMore,
        ]);
    }
}
