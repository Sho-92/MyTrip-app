<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\TripPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransportationController extends Controller
{
    /**
     * 一覧を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $transportations = Transportation::all();
        return view('transportations.index', compact('transportations'));
    }

    /**
     * 新規作成フォームを表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tripPlanId):View
    {
        // 指定された旅行プランのIDを持つTripPlanモデルを取得
        $tripPlan = TripPlan::findOrFail($tripPlanId);

        return view('transportations.create', [
            'tripPlan' => $tripPlan,  // tripPlanオブジェクトを渡す
            'tripPlanId' => $tripPlanId
        ]);
    }


    /**
     * 新規作成を処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request): RedirectResponse
     {
         $validated = $request->validate([
             'trip_plan_id' => 'required|exists:trip_plans,id',
             'date' => 'required|date',
             'departure_time' => 'required',
             'arrival_time' => 'nullable',
             'departure_location' => 'required|string|max:255',
             'arrival_location' => 'required|string|max:255',
             'transportation_mode' => 'required|string',
             'notes' => 'nullable|string',
         ]);

         Transportation::create($validated);

         return redirect()->route('trip_plans.show', $request->trip_plan_id)
             ->with('success', 'Transportation added successfully!');
     }


    /**
     * 詳細を表示
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function show(Transportation $transportation): View
    {
        return view('transportations.show', compact('transportation'));
    }

    /**
     * 編集フォームを表示
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function edit($tripPlanId, $id): View
    {
        // 指定された旅行プランのIDを持つTransportationモデルを取得
        $transportation = Transportation::findOrFail($id);
        // 指定された旅行プランのIDを持つTripPlanモデルを取得
        $tripPlan = TripPlan::findOrFail($tripPlanId);

        return view('transportations.edit', [
            'tripPlan' => $tripPlan,
            'transportation' => $transportation
        ]);
    }


    /**
     * 編集を処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tripPlanId, Transportation $transportation): RedirectResponse
    {
        // リクエストデータのバリデーション
        $validatedData = $request->validate([
            'date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'nullable|date_format:H:i',
            'departure_location' => 'required|string|max:255',
            'arrival_location' => 'required|string|max:255',
            'transportation_mode' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Transportationモデルの更新
        $transportation->update($validatedData);

        // リダイレクト（trip_plan_id を含める）
        return redirect()->route('trip_plans.show', ['trip_plan' => $tripPlanId])
                         ->with('success', 'Transportation updated successfully.');
    }


    /**
     * 削除を処理
     *
     * @param  \App\Models\Transportation  $transportation
     * @return \Illuminate\Http\Response
     */
        public function destroy($tripPlanId, Transportation $transportation): RedirectResponse
    {
        $transportation->delete();

        return redirect()->route('trip_plans.show', $tripPlanId)
                        ->with('success', 'Transportation deleted successfully.');

    }
}
