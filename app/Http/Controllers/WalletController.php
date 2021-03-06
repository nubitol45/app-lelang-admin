<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositInfoResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\WalletResource;
use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Member;
use App\Laravue\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        return new WalletResource($wallet);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        if ($wallet === null) {
            return response()->json(['error' => 'wallet not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                // 'deposit_amount' => ['required']
            ]
        );

        $status = "approved";

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            if (array_key_exists("sender", $params)) {
                $wallet->balance = $wallet->balance + $params['deposit_amount'];
                $wallet->history()->create([
                    'wallet_id' => $params['wallet_id'],
                    'keterangan' => 'setor',
                    'nominal' => $params['deposit_amount'],
                    'ending_balance' => $wallet->balance = $wallet->balance + $params['deposit_amount'],
                ]);
                $relasi = $wallet->deposit();
            } else {
                $wallet->balance = $wallet->balance - $params['withdraw_amount'];
                $wallet->history()->create([
                    'wallet_id' => $params['wallet_id'],
                    'keterangan' => 'tarik',
                    'nominal' => $params['withdraw_amount'],
                    'ending_balance' => $wallet->balance = $wallet->balance + $params['withdraw_amount'],
                ]);
                $relasi = $wallet->withdraw();
            }
            $wallet->save();
            $relasi->where(['id' => $params['id']])->update([
                'status' => $status,
            ]);
        }

        return new walletResource($wallet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
