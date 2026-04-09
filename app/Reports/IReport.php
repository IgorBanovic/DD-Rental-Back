<?php

namespace App\Reports;
use Barryvdh\DomPDF\PDF;

interface IReport
{
    public function getReportType(string $view, array $params = []): PDF;

    public function getData(array $params = []): array;

    public function download(array $params = []): string;
}
