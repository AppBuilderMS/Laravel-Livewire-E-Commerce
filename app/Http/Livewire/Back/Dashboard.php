<?php

namespace App\Http\Livewire\Back;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{


    public function updateOrderStatus($order_id, $status)
    {
        $order = Order::findOrFail($order_id);
        $order->status = $status;
        if($status == 'delivered'){
            $order->delivered_date = DB::raw('CURRENT_DATE');
        }elseif ($status == 'canceled'){
            $order->canceled_date = DB::raw('CURRENT_DATE');
        }
        $order->save();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Order status has been updated successfully!',
        ]);
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home'],
        ];
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $totalSales = Order::where('status', 'delivered')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $todaySales = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::where('status', 'delivered')->whereDate('created_at', Carbon::today())->sum('total');
        return view('livewire.back.dashboard', [
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'todaySales' => $todaySales,
            'todayRevenue' => $todayRevenue
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}
