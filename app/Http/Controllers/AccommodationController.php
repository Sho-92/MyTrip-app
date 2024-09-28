<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Accommodation;
use App\Models\TripPlan;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    // 一覧表示
    public function index(TripPlan $trip_plan)
    {
        $accommodations = $trip_plan->accommodations()->get();
        return view('accommodations.index', compact('trip_plan', 'accommodations'));
    }

    // 新規作成フォーム表示
    public function create(TripPlan $trip_plan)
    {
        return view('accommodations.create', compact('trip_plan'));
    }

    // 新規作成処理
    public function store(Request $request, $tripPlanId)
    {
        // 基本のバリデーション
        $validated = $request->validate([
            'check_in_date' => 'required|date|before_or_equal:check_out_date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // チェックイン日とチェックアウト日が同じ場合のみ、チェックイン時間がチェックアウト時間よりも前か確認
        if ($request->check_in_date == $request->check_out_date) {
            $checkIn = Carbon::createFromFormat('Y-m-d H:i', $request->check_in_date . ' ' . $request->check_in_time);
            $checkOut = Carbon::createFromFormat('Y-m-d H:i', $request->check_out_date . ' ' . $request->check_out_time);

            if ($checkIn >= $checkOut) {
                return back()->withErrors(['check_in_time' => '同じ日の場合、チェックイン時間はチェックアウト時間よりも前でなければなりません。']);
            }
        }

        // バリデーションを通過した場合、宿泊施設を保存
        Accommodation::create([
            'trip_plan_id' => $tripPlanId,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'hotel_name' => $request->hotel_name,
            'address' => $request->address,
            'notes' => $request->notes,
        ]);


        return redirect()->route('trip_plans.show', $tripPlanId )->with('success', '宿泊施設を追加しました。');
    }

    // 詳細表示
    public function show(TripPlan $trip_plan, Accommodation $accommodation)
    {
        return view('accommodations.show', compact('trip_plan', 'accommodation'));
    }

    // 編集フォーム表示
    public function edit(TripPlan $trip_plan, Accommodation $accommodation)
    {
        return view('accommodations.edit', compact('trip_plan', 'accommodation'));
    }

    // 更新処理
    public function update(Request $request, TripPlan $trip_plan, Accommodation $accommodation)
    {
        // 基本のバリデーション
        $validated = $request->validate([
            'check_in_date' => 'required|date|before_or_equal:check_out_date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // チェックイン日とチェックアウト日が同じ場合の時間のチェック
        if ($request->check_in_date == $request->check_out_date) {
            $checkIn = Carbon::createFromFormat('Y-m-d H:i', $request->check_in_date . ' ' . $request->check_in_time);
            $checkOut = Carbon::createFromFormat('Y-m-d H:i', $request->check_out_date . ' ' . $request->check_out_time);

            if ($checkIn >= $checkOut) {
                return back()->withErrors(['check_in_time' => '同じ日の場合、チェックイン時間はチェックアウト時間よりも前でなければなりません。']);
            }
        }

        // 宿泊施設情報の更新
        $accommodation->update([
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'hotel_name' => $request->hotel_name,
            'address' => $request->address,
            'notes' => $request->notes,
        ]);

        return redirect()->route('trip_plans.show', $trip_plan)->with('success', '宿泊施設を更新しました。');
    }


    // 削除処理
    public function destroy(TripPlan $trip_plan, Accommodation $accommodation)
    {
        $accommodation->delete();
        return redirect()->route('trip_plans.show', $trip_plan)->with('success', '宿泊施設を削除しました。');
    }

}
