<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\WithdrawRequest;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use App\Traits\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    use TransactionService;

    protected AccountRepository $accountRepository;

    /**
     * AccountController constructor.
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * show dashboard view
     *
     * @return View
     */
    public function index(): View
    {
        return view('web.dashboard');
    }

    /**
     * show deposit create view
     *
     * @return View
     */
    public function depositCreate(): View
    {
        return view('web.account.deposit');
    }

    /**
     * Store deposit amount to account
     *
     * @param DepositRequest $request
     * @return RedirectResponse
     */
    public function depositStore(DepositRequest $request): RedirectResponse
    {
        $user = Auth::user();
        //get user account detail
        $userAccount = $user->account;

        //update amount
        $userAccount->update([
            'balance' => $userAccount->balance + $request->amount,
        ]);

        //log transaction history
        $this->logTransaction($user, 'credit', $request->amount, 'deposit');

        return redirect()->back()->with('success', "Amount deposited successfully.");
    }

    /**
     * show withdraw create view
     *
     * @return View
     */
    public function withdrawCreate(): View
    {
        return view('web.account.withdraw');
    }

    /**
     * Withdraw amount from account
     *
     * @param WithdrawRequest $request
     * @return RedirectResponse
     */
    public function withdrawStore(WithdrawRequest $request): RedirectResponse
    {
        $user = Auth::user();
        //get user account detail
        $userAccount = $user->account;

        //show error if user balance is lower than requested amount.
        if ($request->amount > $userAccount->balance) {
            return redirect()->back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        //update amount
        $userAccount->update([
            'balance' => $userAccount->balance - $request->amount,
        ]);

        //log transaction history
        $this->logTransaction($user, 'debit', $request->amount, 'withdraw');

        return redirect()->back()->with('success', "Amount withdrawal successfully.");
    }

    /**
     * show Transfer view
     *
     * @return View
     */
    public function transferCreate(): View
    {
        return view('web.account.transfer');
    }

    /**
     * Transfer amount from account
     *
     * @param TransferRequest $request
     * @param UserRepository $userRepository
     * @return RedirectResponse
     */
    public function transferStore(TransferRequest $request, UserRepository $userRepository): RedirectResponse
    {
        $user = Auth::user();
        //get user account detail
        $userAccount = $user->account;

        //get Receiver account detail
        $receiver = $userRepository->allQuery()->with('account')->where('email', $request->email)->first();
        $receiverAccount = $receiver->account;

        //show error if user balance is lower than requested amount.
        if ($request->amount > $userAccount->balance) {
            return redirect()->back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        //update current user amount
        $userAccount->update([
            'balance' => $userAccount->balance - $request->amount,
        ]);
        //log current user transaction history
        $this->logTransaction($user, 'debit', $request->amount, 'transferTo');

        //update receiver user amount
        $receiverAccount->update([
            'balance' => $receiverAccount->balance + $request->amount,
        ]);
        //log receiver transaction history
        $this->logTransaction($receiver, 'credit', $request->amount, 'transferFrom');

        return redirect()->back()->with('success', "Amount transferred successfully.");
    }
}
