<?php

namespace App\Http\Livewire\Front;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
use Cartalyst\Stripe\Stripe;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Checkout extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $line1;
    public $line2;
    public $country;
    public $city;
    public $province;
    public $zipcode;
    public $phone;

    public $ship_to_different;
    public $s_first_name;
    public $s_last_name;
    public $s_email;
    public $s_line1;
    public $s_line2;
    public $s_country;
    public $s_city;
    public $s_province;
    public $s_zipcode;
    public $s_phone;

    public $payment_method;
    public $card_number;
    public $expiry_month;
    public $expiry_year;
    public $cvc;

    public $thank_you;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'first_name' => 'required',
            'last_name'=> 'required',
            'email' => 'required|email',
            'line1' => 'required',
            'country' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'phone' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        if($this->ship_to_different == 1)
        {
            $this->validateOnly($fields,[
                's_first_name' => 'required',
                's_last_name'=> 'required',
                's_email' => 'required|email',
                's_line1' => 'required',
                's_country' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_zipcode' => 'required',
                's_phone' => 'required|numeric'
            ]);
        }

        if($this->payment_method === 'card')
        {
            $this->validateOnly($fields, [
               'card_number' => 'required|numeric',
               'expiry_month' => 'required|numeric',
               'expiry_year' => 'required|numeric',
               'cvc' => 'required|numeric',
            ]);
        }
    }

    public function proceed()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name'=> 'required',
            'email' => 'required|email',
            'line1' => 'required',
            'country' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'phone' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->first_name = $this->first_name;
        $order->last_name = $this->last_name;
        $order->email = $this->email;
        $order->phone = $this->phone;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->ship_to_different ? 1 : 0;
        $order->save();

        foreach (Cart::instance('default')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            if($item->options)
            {
                $orderItem->options = serialize($item->options);
            }
            $orderItem->save();
        }

        if($this->ship_to_different == 1)
        {
            $this->validate([
                's_first_name' => 'required',
                's_last_name'=> 'required',
                's_email' => 'required|email',
                's_line1' => 'required',
                's_country' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_zipcode' => 'required',
                's_phone' => 'required|numeric'
            ]);

            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->first_name = $this->s_first_name;
            $shipping->last_name = $this->s_last_name;
            $shipping->email = $this->s_email;
            $shipping->line1 = $this->s_line1;
            $shipping->line2 = $this->s_line2;
            $shipping->city = $this->s_city;
            $shipping->province = $this->s_province;
            $shipping->country = $this->s_country;
            $shipping->zipcode = $this->s_zipcode;
            $shipping->phone = $this->s_phone;
            $shipping->save();
        }

        if($this->payment_method === 'cash')
        {
            $this->makeTransaction($order->id, 'pending');
            $this->resetCart();
        }
        elseif($this->payment_method === 'card')
        {
            $this->validate([
                'card_number' => 'required|numeric',
                'expiry_month' => 'required|numeric',
                'expiry_year' => 'required|numeric',
                'cvc' => 'required|numeric',
            ]);

            $stripe = Stripe::make(env('STRIPE_KEY'));

            try{
                $token = $stripe->tokens()->create([
                   'card' => [
                       'number' => $this->card_number,
                       'exp_month' => $this->expiry_month,
                       'exp_year' => $this->expiry_year,
                       'cvc' => $this->cvc
                   ]
                ]);

                if(!isset($token['id']))
                {
                    session()->flash('stripe_error', 'The stripe token was not generated correctly');
                    $this->thank_you = 0;
                }

                $customer = $stripe->customers()->create([
                    'name' => $this->first_name . ' ' . $this->last_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => [
                        'line1' => $this->line1,
                        'postal_code' => $this->zipcode,
                        'city' => $this->city,
                        'state' => $this->province,
                        'country' => $this->country
                    ],
                    'shipping' => [
                        'name' => $this->first_name . ' ' . $this->last_name,
                        'address' => [
                            'line1' => $this->line1,
                            'postal_code' => $this->zipcode,
                            'city' => $this->city,
                            'state' => $this->province,
                        ]
                    ],
                    'source' => $token['id']
                ]);

                $chrage = $stripe->charges()->create([
                    'customer' => $customer['id'],
                    'currency' => 'USD',
                    'amount' => session()->get('checkout')['total'],
                    'description' => 'payment for order numbber ' . $order->id
                ]);

                if($chrage['status'] == 'succeeded')
                {
                    $this->makeTransaction($order->id, 'approved');
                    $this->resetCart();
                }
                else{
                    session()->flash('stripe_error', 'Error in transaction');
                    $this->thank_you = 0;
                }

            }catch (Exception $e){
                session()->flash('stripe_error', $e->getMessage());
                $this->thank_you = 0;
            }

        }

        $this->sendOrderConfirmationMail($order);

    }

    public function makeTransaction($order_id, $status)
    {
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order_id;
        $transaction->payment_method = $this->payment_method;
        $transaction->status = $status;
        $transaction->save();
    }

    public function sendOrderConfirmationMail($order)
    {
        Mail::to($order->email)->send(new OrderMail($order));
    }

    public function verifyForCheckout()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        elseif ($this->thank_you)
        {
            return redirect()->route('thankyou');
        }

        elseif (!session()->get('checkout'))
        {
            return redirect()->route('cart.index');
        }
    }

    public function resetCart()
    {
        Cart::instance('default')->destroy();
        $this->thank_you = 1;
        session()->forget('checkout');
        session()->put('checkoutDone', ['done' => 'endCheckout']);
    }

    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.front.checkout')->layout('front-end.layout.app', ['title' => 'Checkout | E-Commerce']);
    }
}
