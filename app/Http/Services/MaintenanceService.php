<?php

namespace App\Http\Services;

use App\Models\Maintenance;
use Exception;

class MaintenanceService
{
    /**
     * @throws Exception
     */
    public function store(array $data): Maintenance
    {
        $maintenance = new Maintenance($data);
        if (!$maintenance->save()) {
            throw new Exception('Error saving maintenance information', 500);
        }

        return $maintenance;
    }

    /**
     * @throws Exception
     */
    public function update(array $data, Maintenance $maintenance): Maintenance
    {
        if(!$maintenance->update($data)) {
            throw new Exception('Error updating maintenance information', 500);
        }

        return $maintenance;
    }

    /**
     * @throws Exception
     */
    public function destroy(Maintenance $maintenance): void
    {
        if(!$maintenance->delete()) {
            throw new Exception('Error deleting maintenance information', 500);
        }
    }

}
