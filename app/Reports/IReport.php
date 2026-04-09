<?php

namespace App\Reports;

interface IReport
{
    public function getReportType(string $view, array $params = []);

    public function getData(array $params = []): array;

    public function download(array $params = []): string;
}
