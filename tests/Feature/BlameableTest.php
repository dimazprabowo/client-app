<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlameableTest extends TestCase
{
    use RefreshDatabase;

    public function test_created_by_and_updated_by_filled_from_auth_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::create(['code' => 'CMP1', 'name' => 'Perusahaan Uji', 'status' => 'active']);

        $this->assertSame($user->id, $company->created_by);
        $this->assertSame($user->id, $company->updated_by);
    }

    public function test_updated_by_changes_on_update_but_created_by_stays(): void
    {
        $creator = User::factory()->create();
        $editor = User::factory()->create();

        $this->actingAs($creator);
        $company = Company::create(['code' => 'CMP2', 'name' => 'Perusahaan Uji 2', 'status' => 'active']);

        $this->actingAs($editor);
        $company->update(['name' => 'Perusahaan Uji 2 Revisi']);

        $this->assertSame($creator->id, $company->created_by);
        $this->assertSame($editor->id, $company->updated_by);
    }

    public function test_audit_columns_null_when_no_authenticated_user(): void
    {
        $company = Company::create(['code' => 'CMP3', 'name' => 'Perusahaan Tanpa Auth', 'status' => 'active']);

        $this->assertNull($company->created_by);
        $this->assertNull($company->updated_by);
    }

    public function test_creator_and_updater_relations_resolve_users(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::create(['code' => 'CMP4', 'name' => 'Perusahaan Relasi', 'status' => 'active']);

        $this->assertTrue($company->creator->is($user));
        $this->assertTrue($company->updater->is($user));
    }
}
