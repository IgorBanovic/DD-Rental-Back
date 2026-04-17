<?php

namespace App\Reports;

interface IReport
{
    public array $parameters { get; }
    public function validate(array $data): bool;
    public function getReportType(string $view, array $params = []);

    public function getData(array $params = []): array;

    public function download(array $params = []): string;
}
