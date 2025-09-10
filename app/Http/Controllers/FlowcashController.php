<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flowcash;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlowcashController extends Controller
{
    public function index() {
        $flowcash = Flowcash::orderBy("created_at","desc")->paginate(20);
        $categories = Category::where('user_id', 1)->get();
        $users = User::all();

        $wallets = Wallet::where('user_id', 1)->get();
        $balance = 0;
        foreach ($wallets as $wallet) {
            $balance += $wallet->balance;
        }

        $incomeTotal = 0;
        $expenseTotal = 0;
        $flowcashes = Flowcash::where('user_id', 1)->whereMonth('created_at', Carbon::now()->month)->get();
        $thisMonthTransaction = $flowcashes->count();
        foreach ($flowcashes as $flow) {
            if ($flow->category->type == 'expense') {
                $expenseTotal += $flow->amount;
            } else {
                $incomeTotal += $flow->amount;
            }
        }

        return view("main-view.flowcash", compact('flowcash', 'categories', 'users', 'balance', 'incomeTotal', 'expenseTotal', 'thisMonthTransaction', 'wallets'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'wallet_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'transaction_date' => 'required'
        ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Flowcash::create($request->all());
        return redirect()->back()->with('success','Success to add transaction');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'wallet_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'transaction_date' => 'required'
        ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Simpan perubahan transaksi
        $flowcash = Flowcash::where('user_id', $request->user_id)->first();
        $flowcash->wallet_id = $request->wallet_id;
        $flowcash->user_id = $request->user_id;
        $flowcash->amount = $request->amount;
        $flowcash->description = $request->description;
        $flowcash->category_id = $request->category_id;
        $flowcash->transaction_date = $request->transaction_date;
        $flowcash->update();
        
        return redirect()->back()->with('success', 'Transaksi berhasil diupdate!');
    }
}
