<?php

namespace App\Http\Controllers;
use Laravel\Cashier\Cashier;
use App\Models\customer;
use Illuminate\Http\Request;
use Laravel\Cashier\Payment;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $Customers=Customer::all();
        $customer = Cashier::stripe()->customers->all();
        return view('customer.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(customer $customer)
    {
        return view('Form.create', [
            'user'=>$customer,
            'intent' => $customer->createSetupIntent()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,customer $customer)
    {
        $data = $request->all();
        $options=[
            'name'=> $data['card-holder-name']
        ];
        // $stripeCustomer = $customer->createAsStripeCustomer($options);
        $paymentMethod = $data['payment_method'];
        $customer->createOrGetStripeCustomer($options);
        $customer->addPaymentMethod($paymentMethod);
        try
        {
        $customer->charge(5*100, $paymentMethod);
        }
        catch (\Exception $e)
        {
        return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return redirect('/customer');
    }




    public function createSepa(customer $customer)
    {
        $payment =$customer->payWith(50*100, ['sepa_debit']);
        $SetupIntent=Cashier::stripe()->setupIntents->create(['payment_method_types' => ['sepa_debit']]);
        // $SetupIntent=$customer->createSetupIntent();
        // $SetupIntent->payment_method_types=['card','sepa_debit'];
        // dd($SetupIntent);
        // $SetupIntent->payment_method_options=[];
        return view('Form.createSepa', [
            'user'=>$customer,
            'SetupIntent' => $SetupIntent,
            'PaymentIntent'=>$payment->client_secret
        ]);
    }

        // public function paymentIntent(Request $request)
    // {
    //     $payment = $request->customer()->payWith(
    //         100, ['sepa_debit']
    //     );
    
    //     return $payment->client_secret;
    // }


    public function storeSepa(Request $request,customer $customer)
    {
        $data = $request->all();
        $options=[
            'name'=> $data['name'],
            'email'=>$data['email']
        ];
        // dd($options);
        // $stripeCustomer = $customer->createAsStripeCustomer($options);
        $paymentMethod = $data['payment_method'];
        $customer->createOrGetStripeCustomer($options);
        // dd($data['SetupIntent']);
        $customer->addPaymentMethod($paymentMethod);
        // dd($customer);
        // $customer->updateDefaultPaymentMethod($paymentMethod);
        // $customer->payWith(50*100, ['sepa_debit']);
        // try
        // {
        // $customer->charge(50*100, $paymentMethod);
        // // $()->payWith(50*100, $paymentMethod);
        // }
        // catch (\Exception $e)
        // {
        // dd($e->getMessage());
        // return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        // }
        return redirect('/customer');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($stripeId)
    {
        // $this->StoreView($customer);
        // $customer = Cashier::stripe()->customers->where('id','');
        $customer = Cashier::findBillable($stripeId);
        return view('customer.show', compact("customer"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        return view('Form.edit', [
            'user'=>$customer,
            'intent' => $customer->createSetupIntent()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        //
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        //
    }
}
