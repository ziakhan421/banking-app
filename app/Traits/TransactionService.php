<?php

namespace App\Traits;

use App\Models\Transaction;

trait TransactionService
{
    /**
     * @param $user
     * @param $type
     * @param $amount
     * @param $action
     * @param null $receiver
     * @return void
     */
    public function logTransaction($user, $type, $amount, $action, $receiver = null): void
    {
        $description = match ($action) {
            'deposit' => 'Deposit',
            'withdraw' => 'Withdraw',
            'transferFrom' => 'Transfer from ' . $receiver->email,
            'transferTo' => 'Transfer to ' . $receiver->email,
            default => '',
        };

        $balance = $user->account->balance;

        Transaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'balance' => $balance,
            'description' => $description,
        ]);
    }
}
