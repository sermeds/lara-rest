<?php

namespace Tests\Feature;

use App\Models\Receipt;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_receipt_can_be_created()
    {
        $payment = Payment::factory()->create();

        $data = [
            'payment_id' => $payment->id,
            'receipt_number' => 'R-123456',
            'amount' => 100.50,
            'issued_at' => now()->toDateString(),
            'tax_amount' => 10.00,
            'pdf_url' => 'http://example.com/receipt.pdf',
            'status' => 'issued',
        ];

        $response = $this->postJson('/api/receipts', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('receipts', $data);
    }

    public function test_receipt_can_be_updated()
    {
        $receipt = Receipt::factory()->create();

        $data = [
            'status' => 'cancelled',
        ];

        $response = $this->putJson("/api/receipts/{$receipt->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('receipts', $data);
    }

    public function test_receipt_can_be_deleted()
    {
        $receipt = Receipt::factory()->create();

        $response = $this->deleteJson("/api/receipts/{$receipt->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('receipts', ['id' => $receipt->id]);
    }
}
