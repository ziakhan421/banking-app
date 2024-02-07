<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;

class TransactionController extends Controller
{
    protected TransactionRepository $transactionRepository;

    /**
     * TransactionController constructor.
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * show transactions history
     *
     * @param Request $request
     * @return JsonResponse|View
     * @throws \Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = $this->transactionRepository->allQuery()->where('user_id', auth()->id())->latest();

                return datatables()->of($data)
                    ->addColumn('datetime', function ($row) {
                        return $row->created_at_formatted;
                    })
                    ->addColumn('type', function ($row) {
                        return ucfirst($row->type);
                    })
                    ->make();
            }
            return view('web.statement.index');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

}
