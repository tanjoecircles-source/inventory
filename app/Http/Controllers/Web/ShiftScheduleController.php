<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use App\Models\ShiftPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ShiftScheduleController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $keyword = $request->keyword ?? '';
        $period_id = $request->period_id;
        
        $schedules = ShiftSchedule::with('period')
            ->when($keyword, function($q) use ($keyword) {
                $q->where('employee_name', 'like', "%$keyword%")
                  ->orWhere('shift_date', 'like', "%$keyword%")
                  ->orWhere('shift_type', 'like', "%$keyword%");
            })
            ->when($period_id, function($q) use ($period_id) {
                $q->where('shift_period_id', $period_id);
            })
            ->orderBy('shift_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);
        
        $periods = ShiftPeriod::orderBy('start_date', 'desc')->get();
        
        if ($request->ajax()) {
            $view = view('web.admin.shift_schedule.paginate', compact('schedules'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('web.admin.shift_schedule.list', compact('schedules', 'periods', 'period_id'));
    }

    public function add(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $period_id = $request->period_id;
        $employees = DB::table('employee')->orderBy('name', 'asc')->get();
        $periods = ShiftPeriod::orderBy('start_date', 'desc')->get();
        
        // Generate dates based on selected period
        $dates = [];
        if ($period_id) {
            $period = ShiftPeriod::find($period_id);
            if ($period) {
                $start = new \DateTime($period->start_date);
                $end = new \DateTime($period->end_date);
                $end->modify('+1 day');
                $interval = new \DateInterval('P1D');
                $periodRange = new \DatePeriod($start, $interval, $end);
                foreach ($periodRange as $date) {
                    $dates[] = $date->format('Y-m-d');
                }
            }
        }
        
        return view('web.admin.shift_schedule.add', compact('employees', 'periods', 'period_id', 'dates'));
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'shift_period_id' => 'required|exists:shift_periods,id',
            'employee_name' => 'required|string|max:255',
            'shift_date' => 'required',
            'shift_type' => 'required|in:Long,Short',
            'start_time' => 'required',
            'end_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $data = $request->all();
        $data['shift_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['shift_date'])));

        ShiftSchedule::create($data);

        return redirect('shift-schedule-list?period_id='.$data['shift_period_id'])->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $schedule = ShiftSchedule::findOrFail($id);
        $employees = DB::table('employee')->orderBy('name', 'asc')->get();
        $periods = ShiftPeriod::orderBy('start_date', 'desc')->get();
        
        // Generate dates for the period
        $dates = [];
        if ($schedule->shift_period_id) {
            $period = ShiftPeriod::find($schedule->shift_period_id);
            if ($period) {
                $start = new \DateTime($period->start_date);
                $end = new \DateTime($period->end_date);
                $end->modify('+1 day');
                $interval = new \DateInterval('P1D');
                $periodRange = new \DatePeriod($start, $interval, $end);
                foreach ($periodRange as $date) {
                    $dates[] = $date->format('Y-m-d');
                }
            }
        }
        
        return view('web.admin.shift_schedule.edit', compact('schedule', 'employees', 'periods', 'dates'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'shift_period_id' => 'required|exists:shift_periods,id',
            'employee_name' => 'required|string|max:255',
            'shift_date' => 'required',
            'shift_type' => 'required|in:Long,Short',
            'start_time' => 'required',
            'end_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $data = $request->all();
        $data['shift_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['shift_date'])));

        $schedule = ShiftSchedule::findOrFail($id);
        $schedule->update($data);

        return redirect('shift-schedule-list?period_id='.$data['shift_period_id'])->with('success', 'Jadwal shift berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $schedule = ShiftSchedule::findOrFail($id);
        $period_id = $schedule->shift_period_id;
        $schedule->delete();

        return redirect('shift-schedule-list?period_id='.$period_id)->with('success', 'Jadwal shift berhasil dihapus.');
    }
}
