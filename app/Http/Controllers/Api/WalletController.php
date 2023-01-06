<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\UserContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Wallet;
use DB;

class WalletController extends BaseController
{
    public function __construct()
    {
    }

    public function walletCredit(Request $request){
        $this->validate($request, [
            'user_id'      =>  'required',
            'amount'     =>  'required',
        ]);

        $params = $request->except('_token');
        
        $wallet = new Wallet;
        $wallet->user_id = $params['user_id'];
        $wallet->amount = $params['amount'];
        $wallet->type = '1';
        $wallet->transaction_id = $params['transaction_id'];
        $wallet->comment = $params['comment'];

        $wallet->save();

         if (!$wallet) {
            $error = true;
            $message = 'Some error occurred. Please try again';

            return response()->json(compact('error','message'));
        }else{
            $error = false;
            $message = 'Success';

            return response()->json(compact('error','message','wallet'));
        }
    }

    public function userWallets($id){
        $wallets = Wallet::where('user_id',$id)->get();

        $credit_result = DB::select("select ifnull(sum(amount),0) as total_credit from wallets where type=1 and user_id='$id'");
        $debit_result = DB::select("select ifnull(sum(amount),0) as total_debit from wallets where type=2 and user_id='$id'");
        $credit_amount = $credit_result[0]->total_credit;
        $debit_amount = $debit_result[0]->total_debit;

        $wallet_balance = ($credit_amount - $debit_amount);

        $error = false;
        $message = 'Success';

        return response()->json(compact('error','message','wallets','wallet_balance'));
    }
}