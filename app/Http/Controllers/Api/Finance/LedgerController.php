<?php

namespace App\Http\Controllers\Api\Finance;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Finance\LedgerRequest;
use App\Http\Resources\Finance\LedgerCollection;
use App\Http\Resources\Finance\LedgerResource;
use App\Models\Finance\Ledger;
use App\Services\Finance\Interfaces\LedgerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LedgerController extends BaseApiController
{
    protected LedgerServiceInterface $ledgerService;

    public function __construct(LedgerServiceInterface $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return LedgerCollection
     */
    public function index()
    {
        $all = $this->ledgerService->getAllLedgers();

        return new LedgerCollection($all);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LedgerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LedgerRequest $request)
    {
        $validated = $request->validated();

        $newLedger = $this->ledgerService->create($validated);

        return $this->successResponse(new LedgerResource($newLedger), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        return $this->jsonResponse($ledger);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LedgerRequest  $request
     * @param  Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(LedgerRequest $request, Ledger $ledger)
    {
        $validated = $request->validated();

        $updatedLedger = $this->ledgerService->update($ledger, $validated);

        return $this->successResponse(new LedgerResource($updatedLedger));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ledger  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $model)
    {
        $this->ledgerService->destroy($model);

        return $this->successResponse(null, Response::HTTP_NO_CONTENT);
    }
}
