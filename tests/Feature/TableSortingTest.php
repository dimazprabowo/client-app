<?php

namespace Tests\Feature;

use App\Livewire\MasterData\CompanyManagement;
use App\Models\Company;
use App\Models\SystemConfiguration;
use App\Models\User;
use App\Services\CompanyService;
use App\Services\ImpersonateService;
use App\Services\SystemConfigurationService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TableSortingTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_service_sorts_by_whitelisted_field_and_direction(): void
    {
        Company::create(['code' => 'B', 'name' => 'Beta', 'status' => 'active']);
        Company::create(['code' => 'A', 'name' => 'Alpha', 'status' => 'active']);
        Company::create(['code' => 'C', 'name' => 'Charlie', 'status' => 'active']);

        $service = app(CompanyService::class);

        $asc = $service->getFiltered(sortField: 'name', sortDir: 'asc');
        $this->assertSame(['Alpha', 'Beta', 'Charlie'], $asc->pluck('name')->all());

        $desc = $service->getFiltered(sortField: 'name', sortDir: 'desc');
        $this->assertSame(['Charlie', 'Beta', 'Alpha'], $desc->pluck('name')->all());
    }

    public function test_unknown_sort_field_falls_back_to_default(): void
    {
        Company::create(['code' => 'B', 'name' => 'Beta', 'status' => 'active']);
        Company::create(['code' => 'A', 'name' => 'Alpha', 'status' => 'active']);

        $result = app(CompanyService::class)->getFiltered(sortField: 'malicious_column', sortDir: 'asc');

        $this->assertSame(['Alpha', 'Beta'], $result->pluck('name')->all());
    }

    public function test_null_values_sorted_first_on_asc_and_last_on_desc(): void
    {
        Company::create(['code' => 'N', 'name' => 'No Npwp', 'status' => 'active', 'npwp' => null]);
        Company::create(['code' => 'Z', 'name' => 'Zeta', 'status' => 'active', 'npwp' => '999999999999999']);
        Company::create(['code' => 'A', 'name' => 'Alpha', 'status' => 'active', 'npwp' => '111111111111111']);

        $service = app(CompanyService::class);

        $asc = $service->getFiltered(sortField: 'npwp', sortDir: 'asc');
        $this->assertSame('No Npwp', $asc->first()->name);
        $this->assertSame('Zeta', $asc->last()->name);

        $desc = $service->getFiltered(sortField: 'npwp', sortDir: 'desc');
        $this->assertSame('Zeta', $desc->first()->name);
        $this->assertSame('No Npwp', $desc->last()->name);
    }

    public function test_company_service_sorts_by_users_count(): void
    {
        $empty = Company::create(['code' => 'E', 'name' => 'Empty Co', 'status' => 'active']);
        $full = Company::create(['code' => 'F', 'name' => 'Full Co', 'status' => 'active']);
        User::factory()->count(3)->create(['company_id' => $full->id]);

        $result = app(CompanyService::class)->getFiltered(sortField: 'users_count', sortDir: 'desc');

        $this->assertSame('Full Co', $result->first()->name);
        $this->assertSame('Empty Co', $result->last()->name);
    }

    public function test_user_service_sorts_by_company_name_and_approval_workflow(): void
    {
        $beta = Company::create(['code' => 'B', 'name' => 'Beta Corp', 'status' => 'active']);
        $alpha = Company::create(['code' => 'A', 'name' => 'Alpha Corp', 'status' => 'active']);

        User::factory()->create(['name' => 'U1', 'company_id' => $beta->id, 'approval_status' => 'rejected']);
        User::factory()->create(['name' => 'U2', 'company_id' => $alpha->id, 'approval_status' => 'approved']);
        User::factory()->create(['name' => 'U3', 'company_id' => null, 'approval_status' => 'pending']);

        $service = app(UserService::class);

        // Sort by company subquery — user tanpa company (NULL) paling atas saat asc.
        $byCompany = $service->getFilteredUsers(sortField: 'company', sortDir: 'asc');
        $this->assertSame(['U3', 'U2', 'U1'], $byCompany->pluck('name')->all());

        // approval_status mengikuti urutan enum: pending -> approved -> rejected.
        $byApproval = $service->getFilteredUsers(sortField: 'approval_status', sortDir: 'asc');
        $this->assertSame(['U3', 'U2', 'U1'], $byApproval->pluck('name')->all());
    }

    public function test_system_configuration_default_sort_is_category_then_key(): void
    {
        SystemConfiguration::create(['key' => 'b.key', 'category' => 'threshold', 'value' => '1', 'data_type' => 'integer']);
        SystemConfiguration::create(['key' => 'a.key', 'category' => 'general', 'value' => '1', 'data_type' => 'integer']);
        SystemConfiguration::create(['key' => 'z.key', 'category' => 'general', 'value' => '1', 'data_type' => 'integer']);

        $service = app(SystemConfigurationService::class);

        $default = $service->getFiltered();
        $this->assertSame(['a.key', 'z.key', 'b.key'], $default->pluck('key')->all());

        $byKeyDesc = $service->getFiltered(sortField: 'key', sortDir: 'desc');
        $this->assertSame(['z.key', 'b.key', 'a.key'], $byKeyDesc->pluck('key')->all());
    }

    public function test_impersonatable_users_excludes_current_user_even_when_search_matches(): void
    {
        $me = User::factory()->create(['name' => 'Admin Saya', 'email' => 'me@test.com']);
        $other = User::factory()->create(['name' => 'Admin Lain', 'email' => 'other@test.com']);

        $users = app(ImpersonateService::class)->getImpersonatableUsers('Admin', null, $me->id);

        $this->assertSame(['Admin Lain'], $users->pluck('name')->all());
    }

    public function test_livewire_sort_by_toggles_direction_and_switches_field(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::create(['name' => 'companies_view']));
        Company::create(['code' => 'A', 'name' => 'Alpha', 'status' => 'active']);

        Livewire::actingAs($user)
            ->test(CompanyManagement::class)
            ->assertSet('sortField', 'name')
            ->assertSet('sortDir', 'asc')
            ->call('sortBy', 'name')
            ->assertSet('sortDir', 'desc')
            ->call('sortBy', 'email')
            ->assertSet('sortField', 'email')
            ->assertSet('sortDir', 'asc');
    }
}
