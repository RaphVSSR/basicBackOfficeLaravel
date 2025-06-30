@extends(backpack_view('blank'))

@php
use Carbon\Carbon;

$dates = [];
$labels = [];
for ($i = 29; $i >= 0; $i--) {
    $carbonDate = Carbon::now()->subDays($i);
    $dates[] = $carbonDate->format('Y-m-d');
    $labels[] = $carbonDate->format('d/m');
}

function cumulativeCountByDay($model, $dates)
{
    $counts = [];
    foreach ($dates as $date) {
        // On compte tous les enregistrements créés jusqu'à la fin de ce jour
        $counts[] = $model::whereDate('created_at', '<=', $date)->count();
    }
    return $counts;
}

$articlesData = cumulativeCountByDay(\App\Models\Articles::class, $dates);
$categoriesData = cumulativeCountByDay(\App\Models\Categories::class, $dates);
$usersData = cumulativeCountByDay(\App\Models\Users::class, $dates);

// Mois actuel pour les titres (sans année)
$currentMonth = ucfirst(Carbon::now()->isoFormat('MMMM'));

// Prépare les charts
$articlesChart = new \ConsoleTVs\Charts\Classes\Chartjs\Chart;
$articlesChart->labels($labels);
$articlesChart->dataset('Total', 'line', $articlesData)
    ->backgroundColor('rgba(54, 162, 235, 0.15)')
    ->color('rgba(54, 162, 235, 1)')
    ->options([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'stepSize' => 1,
                    'precision' => 0,
                ],
            ],
        ],
    ]);
$articlesChart->id = 'articlesChart';

$categoriesChart = new \ConsoleTVs\Charts\Classes\Chartjs\Chart;
$categoriesChart->labels($labels);
$categoriesChart->dataset('Total', 'line', $categoriesData)
    ->backgroundColor('rgba(255, 99, 132, 0.15)')
    ->color('rgba(255, 99, 132, 1)')
    ->options([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'stepSize' => 1,
                    'precision' => 0,
                ],
            ],
        ],
    ]);
$categoriesChart->id = 'categoriesChart';

$usersChart = new \ConsoleTVs\Charts\Classes\Chartjs\Chart;
$usersChart->labels($labels);
$usersChart->dataset('Total', 'line', $usersData)
    ->backgroundColor('rgba(75, 192, 192, 0.15)')
    ->color('rgba(75, 192, 192, 1)')
    ->options([
        'responsive' => true,
        'maintainAspectRatio' => false,
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'stepSize' => 1,
                    'precision' => 0,
                ],
            ],
        ],
    ]);
$usersChart->id = 'usersChart';
@endphp

@section('content')
    @vite("resources/css/app.css")

    <main class="!flex flex-col overflow-hidden">
        <h1 class="!text-4xl font-extrabold text-gray-800 !mb-5 ml-8 tracking-tight">Tables</h1>
        <!-- Ligne 1 : 2 colonnes -->
        <div class="flex flex-row w-full gap-[2%] px-[2%] mb-[2%]">
            <div class="flex flex-col flex-1 bg-white rounded-2xl shadow-md">
                <h2 class="!text-xl font-bold text-gray-700 m-0 pl-5 pt-3">Articles</h2>
                <div class="max-h-[30vh] m-0 px-2 pb-2 items-center w-full">
                    {!! $articlesChart->container() !!}
                </div>
            </div>
            <div class="flex flex-col flex-1 bg-white rounded-2xl shadow-md">
                <h2 class="!text-xl font-bold text-gray-700 m-0 pl-5 pt-3">Categories</h2>
                <div class="max-h-[30vh] m-0 px-2 pb-2 items-center w-full">
                    {!! $categoriesChart->container() !!}
                </div>
            </div>
        </div>
        <!-- Ligne 2 : pleine largeur -->
        <div class="w-full px-[2%]">
            <div class="flex flex-col bg-white rounded-2xl shadow-md w-full">
                <h2 class="!text-xl font-bold text-gray-700 m-0 pl-5 pt-3">Users</h2>
                <div class="max-h-[35vh] items-center w-full px-2 pb-2">
                    {!! $usersChart->container() !!}
                </div>
            </div>
        </div>
    </main>
@endsection


@push('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{!! $articlesChart->script() !!}
{!! $categoriesChart->script() !!}
{!! $usersChart->script() !!}
@endpush

