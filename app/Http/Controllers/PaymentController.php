<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function createTransaction(Request $request, $id)
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-hN_W5twAUmnUpzJtA0VPfeSy';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->price,
            ),
         );

        $snapToken = Snap::getSnapToken($params);

        return view('home.payment', compact('snapToken', 'order'));
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $order->status_pembayaran = 'Sudah Bayar'; // Update status pembayaran
        $order->save();

        return redirect('my_order');
    }

    public function updateShipment(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $order->status_pengiriman = 'Sudah Dikirim'; // Update status pengiriman
        $order->save();

        return redirect()->back()->with('success', 'Shipment status updated successfully.');
    }

}