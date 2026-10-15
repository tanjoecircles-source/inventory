<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ShiftPeriod;
use App\Models\ShiftSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ShiftPeriodController extends Controller
{
    public function list()
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $periods = ShiftPeriod::orderBy('start_date', 'desc')->paginate(20);
        
        return view('web.admin.shift_schedule.period_list', compact('periods'));
    }

    public function add()
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $periodes = DB::table('periode')->orderBy('start_date', 'desc')->get();
        $weeks = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        
        return view('web.admin.shift_schedule.period_add', compact('periodes', 'weeks'));
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'month' => 'required|string|max:255',
            'week' => 'required|string|max:50',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $data = $request->all();
        $data['name'] = $data['month'].' - '.$data['week'];
        $data['start_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date'])));
        $data['end_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])));

        $period = ShiftPeriod::create($data);

        return redirect('shift-period-detail/'.$period->id)->with('success', 'Periode shift berhasil ditambahkan.');
    }

    public function detail($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $period = ShiftPeriod::findOrFail($id);
        $employees = DB::table('employee')->orderBy('name', 'asc')->get();
        
        // Generate all dates in the period range
        $dates = [];
        $start = new \DateTime($period->start_date);
        $end = new \DateTime($period->end_date);
        $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $periodRange = new \DatePeriod($start, $interval, $end);
        
        $days = [];
        foreach ($periodRange as $date) {
            $dateStr = $date->format('Y-m-d');
            $dayName = $date->format('l'); // Monday, Tuesday, etc
            $indonesianDays = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            
            // Load existing shift for this date
            $existingShift = ShiftSchedule::where('shift_period_id', $id)
                ->where('shift_date', $dateStr)
                ->first();
            
            $days[] = [
                'date' => $dateStr,
                'day_name' => $indonesianDays[$dayName] ?? $dayName,
                'shift' => $existingShift,
            ];
        }
        
        return view('web.admin.shift_schedule.period_detail', compact('period', 'employees', 'days'));
    }

    public function storeShift(Request $request, $periodId)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'shift_date' => 'required',
            'shift1_employee' => 'nullable|string|max:255',
            'shift1_type' => 'nullable|in:Long,Short,Off',
            'shift1_start' => 'nullable',
            'shift1_end' => 'nullable',
            'shift2_employee' => 'nullable|string|max:255',
            'shift2_type' => 'nullable|in:Long,Short,Off',
            'shift2_start' => 'nullable',
            'shift2_end' => 'nullable',
        ]);

        $shiftDate = date('Y-m-d', strtotime(str_replace('/', '-', $request->shift_date)));

        $data = [
            'shift_date' => $shiftDate,
            'shift1_employee' => $request->shift1_employee,
            'shift1_type' => $request->shift1_type,
            'shift1_start' => $request->shift1_start,
            'shift1_end' => $request->shift1_end,
            'shift2_employee' => $request->shift2_employee,
            'shift2_type' => $request->shift2_type,
            'shift2_start' => $request->shift2_start,
            'shift2_end' => $request->shift2_end,
        ];

        $existing = ShiftSchedule::where('shift_period_id', $periodId)
            ->where('shift_date', $shiftDate)
            ->first();

        if ($existing) {
            $existing->update($data);
        } else {
            $data['shift_period_id'] = $periodId;
            ShiftSchedule::create($data);
        }

        return redirect('shift-period-detail/'.$periodId)->with('success', 'Shift untuk '.date('d M Y', strtotime($shiftDate)).' berhasil disimpan.');
    }

    public function duplicateForm($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $source = ShiftPeriod::findOrFail($id);
        $periodes = DB::table('periode')->orderBy('start_date', 'desc')->get();
        $weeks = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];

        // Saran periode berikutnya: mulai sehari setelah periode lama berakhir, durasi sama
        $start = new \DateTime($source->start_date);
        $end = new \DateTime($source->end_date);
        $duration = (int) $start->diff($end)->format('%a') + 1;
        $nextStart = (clone $end)->modify('+1 day');
        $nextEnd = (clone $nextStart)->modify('+'.($duration - 1).' days');

        // Saran minggu: naik 1 tingkat (Minggu 4 -> kembali ke Minggu 1)
        $weekNum = 1;
        if (preg_match('/(\d+)/', $source->week ?? '', $m)) {
            $weekNum = ((int) $m[1] % 4) + 1;
        }
        $suggestWeek = 'Minggu '.$weekNum;

        // Saran bulan: periode (tabel periode) yang memuat tanggal mulai berikutnya
        $suggestMonth = $source->month;
        $matchPeriode = DB::table('periode')
            ->where('start_date', '<=', $nextStart->format('Y-m-d'))
            ->where('end_date', '>=', $nextStart->format('Y-m-d'))
            ->first();
        if ($matchPeriode) {
            $suggestMonth = $matchPeriode->name;
        }

        $shiftCount = ShiftSchedule::where('shift_period_id', $id)->count();

        return view('web.admin.shift_schedule.period_duplicate', compact(
            'source', 'periodes', 'weeks', 'suggestWeek', 'suggestMonth', 'nextStart', 'nextEnd', 'duration', 'shiftCount'
        ));
    }

    public function duplicateStore(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $request->validate([
            'month' => 'required|string|max:255',
            'week' => 'required|string|max:50',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $source = ShiftPeriod::findOrFail($id);

        $newStart = date('Y-m-d', strtotime(str_replace('/', '-', $request->start_date)));
        $newEnd = date('Y-m-d', strtotime(str_replace('/', '-', $request->end_date)));
        if ($newEnd < $newStart) {
            return back()->withErrors(['end_date' => 'Tanggal selesai harus setelah tanggal mulai.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $period = ShiftPeriod::create([
                'name' => $request->month.' - '.$request->week,
                'month' => $request->month,
                'week' => $request->week,
                'start_date' => $newStart,
                'end_date' => $newEnd,
            ]);

            // Salin jadwal hari-ke-hari berurutan (offset dari tanggal mulai periode lama)
            $schedules = ShiftSchedule::where('shift_period_id', $id)
                ->orderBy('shift_date', 'asc')
                ->get();

            $copied = 0;
            foreach ($schedules as $s) {
                $offset = (int) (new \DateTime($source->start_date))->diff(new \DateTime($s->shift_date))->format('%r%a');
                if ($offset < 0) continue;
                $newDate = date('Y-m-d', strtotime($newStart.' +'.$offset.' days'));
                if ($newDate > $newEnd) continue;
                ShiftSchedule::create([
                    'shift_period_id' => $period->id,
                    'shift_date' => $newDate,
                    'shift1_employee' => $s->shift1_employee,
                    'shift1_type' => $s->shift1_type,
                    'shift1_start' => $s->shift1_start,
                    'shift1_end' => $s->shift1_end,
                    'shift2_employee' => $s->shift2_employee,
                    'shift2_type' => $s->shift2_type,
                    'shift2_start' => $s->shift2_start,
                    'shift2_end' => $s->shift2_end,
                ]);
                $copied++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menduplikat periode: '.$e->getMessage()])->withInput();
        }

        return redirect('shift-period-detail/'.$period->id)
            ->with('success', 'Periode berhasil diduplikat ('.$copied.' jadwal disalin).');
    }

    public function edit($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $period = ShiftPeriod::findOrFail($id);
        $periodes = DB::table('periode')->orderBy('start_date', 'desc')->get();
        $weeks = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        
        return view('web.admin.shift_schedule.period_edit', compact('period', 'periodes', 'weeks'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'month' => 'required|string|max:255',
            'week' => 'required|string|max:50',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $data = $request->all();
        $data['name'] = $data['month'].' - '.$data['week'];
        $data['start_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date'])));
        $data['end_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])));

        $period = ShiftPeriod::findOrFail($id);
        $period->update($data);

        return redirect('shift-period-detail/'.$id)->with('success', 'Periode shift berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $period = ShiftPeriod::findOrFail($id);
        $period->delete();

        return redirect('shift-period-list')->with('success', 'Periode shift berhasil dihapus.');
    }
}
