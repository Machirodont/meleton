<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\RateCalculator\RatesRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class LoadCourses extends Command
{
    protected $signature = 'app:load-courses';

    protected $description = 'Load courses from external API';

    public function handle(
        RatesRepository $coursesRepository,
    ): void {
        $url = config('exchanger.courses_source_url');
        $response = Http::get($url);
        if ($response->status() !== 200) {
            return;
        }

        $data = $response->json();

        if (!is_array($data)) {
            return;
        }

        $courses = [];
        foreach ($data as $currencyKey => $currencyData) {
            $courses[$currencyKey] = $currencyData['last'];
        }
        $courses = Arr::sort($courses);

        $coursesRepository->save($courses);
    }
}
