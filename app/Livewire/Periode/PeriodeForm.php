<?php

namespace App\Livewire\Periode;

use App\Models\Periode;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PeriodeForm extends Component
{
    public ?int $periodeId = null;

    public string $name = '';

    public string $start_date = '';

    public string $end_date = '';

    public string $param_url = '';

    public function mount(?int $periodeId = null, string $param_url = ''): void
    {
        $this->periodeId = $periodeId;
        $this->param_url = $param_url;

        if ($this->periodeId) {
            $periode = Periode::find($this->periodeId);
            if ($periode) {
                $this->name = (string) ($periode->name ?? '');
                $this->start_date = !empty($periode->start_date) ? date('d-m-Y', strtotime($periode->start_date)) : '';
                $this->end_date = !empty($periode->end_date) ? date('d-m-Y', strtotime($periode->end_date)) : '';
            }
        }
    }

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama periode wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }

    protected function toDbDate(string $value): string
    {
        return date('Y-m-d', strtotime(str_replace('/', '-', $value)));
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        if ($this->periodeId) {
            $updated = Periode::where('id', $this->periodeId)->update([
                'name' => $this->name,
                'start_date' => $this->toDbDate($this->start_date),
                'end_date' => $this->toDbDate($this->end_date),
            ]);
            if (!$updated) {
                DB::rollBack();
                $this->dispatch('periode-notify', type: 'error', message: 'Data failed to update, try again later');
                return;
            }
            DB::commit();
            session()->flash('success', 'Data has been updated');
        } else {
            $insert = Periode::create([
                'name' => $this->name,
                'start_date' => $this->toDbDate($this->start_date),
                'end_date' => $this->toDbDate($this->end_date),
            ]);
            if (!$insert) {
                DB::rollBack();
                $this->dispatch('periode-notify', type: 'error', message: 'Data failed to create, try again later');
                return;
            }
            DB::commit();
            session()->flash('success', 'Data has been created');
        }

        $target = ($this->param_url === 'true' && !$this->periodeId)
            ? url('purchasing-add')
            : url('periode-list');

        $this->redirect($target, navigate: true);
    }

    public function render()
    {
        return view('livewire.periode.periode-form');
    }
}
