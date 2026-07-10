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
