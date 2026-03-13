<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\ShortUrl;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_member_can_create_short_urls()
    {

        $role = Role::create(['role' => 'SUPER_ADMIN']);
        $role = Role::create(['role' => 'ADMIN']);
        $role = Role::create(['role' => 'MEMBER']);
        Company::factory(10)->create();


        $admin = User::factory()->create(['role_id' => 2 , 'company_id'=>2]);
        $member = User::factory()->create(['role_id' => 3 , 'company_id'=>2]);
        $this->actingAs($admin)
            ->post('/create_link', [
                'original_url' => 'https://google.com',
                'company_id' => 2
            ]);
            $this->assertDatabaseHas('short_urls', [
                'original_url' => 'https://google.com',
                'user_id' => $admin->id
            ]);

        $this->actingAs($member)
            ->post('/create_link', [
                'original_url' => 'https://google.com',
                'company_id' => 2
            ]);
            $this->assertDatabaseHas('short_urls', [
                'original_url' => 'https://google.com',
                'user_id' => $member->id
            ]);
    }
    public function test_superadmin_cannot_create_short_urls()
    {
            $role = Role::create(['role' => 'SUPER_ADMIN']);
            $role = Role::create(['role' => 'ADMIN']);
            $role = Role::create(['role' => 'MEMBER']);
            Company::factory(10)->create();


            $superAdmin = User::factory()->create(['role_id' => 1]);

            $this->actingAs($superAdmin)
            ->post('/short-urls', [
                'original_url' => 'https://google.com',
                'company_id' => 1
            ]);
            $this->assertDatabaseMissing('short_urls', [
                'original_url' => 'https://google.com',
                'user_id' => $superAdmin->id
            ]);
    }
    public function test_admin_can_only_see_short_urls_in_their_company()
    {
        $role = Role::create(['role' => 'SUPER_ADMIN']);
        $role = Role::create(['role' => 'ADMIN']);
        $role = Role::create(['role' => 'MEMBER']);
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();

        $admin1 = User::factory()->create([
            'role_id' => 2,
            'company_id' => $company1->id
        ]);
        $admin2 = User::factory()->create([
            'role_id' => 2,
            'company_id' => $company1->id
        ]);
        ShortUrl::factory()->create([
            'company_id' => $company2->id,
            'user_id' => $admin2->id
        ]);

        ShortUrl::factory()->create([
            'company_id' => $company1->id,
            'user_id' => $admin1->id
        ]);

        $response = $this->actingAs($admin1)
            ->get('/show_links');

        $response->assertStatus(200);

        $this->assertCount(1, $response->viewData('links'));
    }

    public function test_member_can_only_see_their_own_short_urls()
    {

        $role = Role::create(['role' => 'SUPER_ADMIN']);
        $role = Role::create(['role' => 'ADMIN']);
        $role = Role::create(['role' => 'MEMBER']);
        $company = Company::factory()->create();


        $member = User::factory()->create([
            'role_id' => 3,
            'company_id' => $company->id
        ]);

        $otherUser = User::factory()->create([
            'role_id' => 3,
            'company_id' => $company->id
        ]);

        ShortUrl::factory()->create([
            'user_id' => $member->id,
            'company_id' => $company->id
        ]);

        ShortUrl::factory()->create([
            'user_id' => $otherUser->id,
            'company_id' => $company->id
        ]);

        $response = $this->actingAs($member)
            ->get('/show_links');

        $response->assertStatus(200);

        $this->assertCount(1, $response->viewData('links'));
    }

    public function test_short_url_redirects_to_original_url()
    {

        $role = Role::create(['role' => 'SUPER_ADMIN']);
        $role = Role::create(['role' => 'ADMIN']);
        $role = Role::create(['role' => 'MEMBER']);
        $company = Company::factory()->create();
        $member = User::factory()->create([
            'role_id' => 3,
            'company_id' => $company->id
        ]);
        $shortUrl = ShortUrl::factory()->create([
            'code' => 'abc123',
            'original_url' => 'https://google.com',
            'user_id' => $member->id,
            'company_id' => $company->id
        ]);

        $this->get('/s/abc123')
            ->assertRedirect('https://google.com');
    }
}
