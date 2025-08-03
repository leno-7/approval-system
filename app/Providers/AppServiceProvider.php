<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProjectRequest;
use App\Observers\ProjectRequestObserver;
use App\Models\ProjectRequestCompletion;
use App\Observers\ProjectRequestCompletionObserver;
use App\Models\FinancialAffair;
use App\Observers\FinancialAffairObserver;
use App\Models\Contract;
use App\Observers\ContractObserver;
use App\Models\PlanningGovernanceApproval;
use App\Observers\PlanningGovernanceApprovalObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ProjectRequest::observe(ProjectRequestObserver::class);
        ProjectRequestCompletion::observe(ProjectRequestCompletionObserver::class);
        FinancialAffair::observe(FinancialAffairObserver::class);
        Contract::observe(ContractObserver::class);
        PlanningGovernanceApproval::observe(PlanningGovernanceApprovalObserver::class);
    }
    


}
