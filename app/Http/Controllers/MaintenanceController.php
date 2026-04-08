<?php

namespace App\Http\Controllers;

use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Http\Requests\Maintenance\UpdateMaintenanceRequest;
use App\Http\Resources\MaintenanceCollection;
use App\Http\Resources\MaintenanceResource;
use App\Http\Services\MaintenanceService;
use App\Models\Maintenance;
use Exception;

class MaintenanceController extends Controller
{
    public function index()
    {
        return new MaintenanceCollection(Maintenance::all());
    }

    public function store(StoreMaintenanceRequest $request, MaintenanceService $maintenanceService)
    {
        try{
            $maintenance = $maintenanceService->store($request->validated());
            return new MaintenanceResource($maintenance);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function update(UpdateMaintenanceRequest $request, MaintenanceService $maintenanceService, Maintenance $maintenance)
    {
        try{
            $maintenance = $maintenanceService->update($request->validated(), $maintenance);
            return new MaintenanceResource($maintenance);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Maintenance $maintenance)
    {
        return new MaintenanceResource($maintenance);
    }

    public function destroy(Maintenance $maintenance, MaintenanceService $maintenanceService)
    {
        try{
            $maintenanceService->destroy($maintenance);
            return response()->json(['message' => 'Maintenance information has been deleted successfully']);
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
