<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'New Users';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $newUsersCount = User::query()
            ->selectRaw('strftime("%m", created_at) as month')
            ->selectRaw('count(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('strftime("%m", created_at)'))
            ->orderBy('created_at')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'New Users Per Month',
                    'data' => $newUsersCount->pluck('count')->toArray(),
                ],
            ],
            'labels' => $this->getMonths($startDate, $endDate),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getMonths($startDate, $endDate): array
    {
        $labels = [];

        for ($i = $startDate->diffInMonths($endDate) -1 ; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $monthAbbreviation = $date->format('M');

            $labels[] = $monthAbbreviation;
        }

        return $labels;
    }
}
