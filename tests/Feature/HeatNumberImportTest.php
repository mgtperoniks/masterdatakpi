<?php

use App\Models\MdDepartment;
use App\Models\MdHeatNumber;
use App\Models\MdItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('rejects duplicates and allows partial success during import', function () {
    // 0. Setup Department (Required for Item)
    $dept = MdDepartment::create([
        'code' => 'DEPT-100',
        'name' => 'Testing Dept',
        'status' => 'active'
    ]);

    // 1. Setup Data
    // Create an Item
    $item = MdItem::create([
        'code' => 'TEST-ITEM-' . uniqid(),
        'name' => 'Test Item',
        'department_code' => $dept->code,
        'cycle_time_sec' => 60,
        'status' => 'active'
    ]);

    $heatNumber = 'HN-TEST-' . uniqid();

    // Create an EXISTING Heat Number
    MdHeatNumber::create([
        'heat_date' => now()->subDay()->toDateString(), // Old date
        'heat_number' => $heatNumber,
        'item_code' => $item->code,
        'item_name' => $item->name,
        'cor_qty' => 10,
        'status' => 'active'
    ]);

    // 2. Prepare Import Data
    $newHeatNumber = 'HN-TEST-NEW-' . uniqid();

    $payload = [
        'heat_date' => now()->toDateString(), // New date
        'data' => [
            // Row 1: DUPLICATE (Same HN + Same Item)
            [
                'heat_number' => $heatNumber,
                'item_code' => $item->code,
                'cor_qty' => 50, // Different qty
                'kode_produksi' => 'TEST',
            ],
            // Row 2: SUCCESS (New HN + Same Item)
            [
                'heat_number' => $newHeatNumber,
                'item_code' => $item->code,
                'cor_qty' => 20,
                'kode_produksi' => 'TEST2',
            ]
        ]
    ];

    // 3. Act
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson(route('master.heat-numbers.bulk-store'), $payload);

    // 4. Assert
    $response->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);

    $responseData = $response->json();

    // Expecting 1 success
    expect($responseData['message'])->toContain('Successfully imported 1 records');

    // Expecting errors for the duplicate
    expect($responseData['errors'])->not->toBeEmpty();
    expect($responseData['errors'][0])->toContain('sudah ada di database');

    // Verify Database
    // 1. The duplicate should NOT be updated (Quantity should remain 10)
    $this->assertDatabaseHas('md_heat_numbers', [
        'heat_number' => $heatNumber,
        'item_code' => $item->code,
        'cor_qty' => 10
    ]);

    // 2. The new one should be created
    $this->assertDatabaseHas('md_heat_numbers', [
        'heat_number' => $newHeatNumber,
        'item_code' => $item->code,
        'cor_qty' => 20
    ]);
});
