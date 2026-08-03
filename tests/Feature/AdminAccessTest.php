<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $this->actingAs($admin)->get("/admin")->assertOk();
    }

    public function test_admin_does_not_see_user_nav_by_default(): void
    {
        $admin = User::factory()->create([
            "role" => "admin",
            "has_paid" => false,
        ]);

        $response = $this->actingAs($admin)->get("/");

        $response->assertOk();
        $response->assertDontSee("Tugas Saya");
        $response->assertSee("Lihat sebagai User");
        $response->assertSee("nav-link--admin");
    }

    public function test_admin_can_enable_preview_mode_to_see_user_nav(): void
    {
        $admin = User::factory()->create([
            "role" => "admin",
            "has_paid" => false,
        ]);
        Assignment::create([
            "user_id" => $admin->id,
            "judul" => "Tugas admin",
            "tugas_teks" => "Teks",
            "status" => "menunggu",
        ]);

        $this->actingAs($admin)
            ->post("/admin/preview/on")
            ->assertRedirect(route("home"));

        $response = $this->actingAs($admin)->get("/");

        $response->assertOk();
        $response->assertSee("Tugas Saya");
        $response->assertSee("Kembali ke Admin");
        $response->assertDontSee("nav-link--admin");
    }

    public function test_admin_can_disable_preview_mode(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        Assignment::create([
            "user_id" => $admin->id,
            "judul" => "Tugas admin",
            "tugas_teks" => "Teks",
            "status" => "menunggu",
        ]);
        $this->actingAs($admin)->post("/admin/preview/on");

        $response = $this->actingAs($admin)->post("/admin/preview/off");

        $response->assertRedirect(route("admin.dashboard"));

        $home = $this->actingAs($admin)->get("/");
        $home->assertDontSee("Tugas Saya");
    }

    public function test_admin_can_access_assignments_page(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $this->actingAs($admin)->get("/assignments")->assertOk();
    }

    public function test_admin_can_send_message_to_user(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $user = User::factory()->create(["role" => "user"]);

        $response = $this->actingAs($admin)->post("/admin/send-to-user", [
            "user_id" => $user->id,
            "judul" => "Pertanyaan dari admin",
            "tugas_teks" => "Tolong review demo saya",
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas("assignments", [
            "user_id" => $user->id,
            "judul" => "Pertanyaan dari admin",
        ]);
    }

    public function test_admin_can_access_coaching_and_courses(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);

        $this->actingAs($admin)->get("/coaching")->assertOk();
        $this->actingAs($admin)->get("/courses")->assertOk();
    }

    public function test_admin_can_buy_coaching(): void
    {
        $admin = User::factory()->create([
            "role" => "admin",
            "has_paid" => false,
        ]);

        $this->actingAs($admin)->get("/payment")->assertOk();

        $response = $this->actingAs($admin)->post("/payment/store", [
            "package_name" => "Textual Review",
            "package_price" => "Rp 100.000",
        ]);

        $response->assertRedirect(route("payment.pending"));
        
        $transaction = $admin->coachingTransactions()->first();
        $this->assertNotNull($transaction);
        $this->assertEquals("pending", $transaction->status);

        $responseApprove = $this->actingAs($admin)->post("/admin/coaching/{$transaction->id}/approve");
        $responseApprove->assertRedirect();
        
        $this->assertTrue($admin->fresh()->has_paid);
    }

    public function test_admin_can_delete_assignment_sent_by_user(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $user = User::factory()->create();
        $assignment = Assignment::create([
            "user_id" => $user->id,
            "judul" => "Tugas dari user",
            "tugas_teks" => "Tolong review demo saya",
            "status" => "menunggu",
        ]);

        $response = $this->actingAs($admin)->delete(
            "/admin/assignments/{$assignment->id}",
        );

        $response->assertRedirect();
        $this->assertDatabaseMissing("assignments", ["id" => $assignment->id]);
    }

    public function test_non_admin_cannot_access_dashboard(): void
    {
        $user = User::factory()->create(["role" => "user"]);

        $this->actingAs($user)->get("/admin")->assertForbidden();
    }
}
