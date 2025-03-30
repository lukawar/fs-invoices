<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @return void
     */
    public function test_can_view_invoices_list()
    {
        // Arrange
        Invoice::factory()->count(3)->create();

        // Act
        $response = $this->actingAs($this->user)->get(route('invoices.index'));

        // Assert
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_can_create_invoice()
    {
        // Arrange
        $invoiceData = [
            'number' => fake()->unique()->numerify('INV-#####'),
            'buyer_nip' => fake()->numerify('1234567890'),
            'seller_nip' => fake()->numerify('1234567890'),
            'product_name' => fake()->word(),
            'amount' => fake()->numberBetween(1, 10),
            'product_price' => fake()->randomFloat(2, 1, 1000),
        ];

        // Act
        $response = $this->actingAs($this->user)->post(route('invoices.create'), $invoiceData);

        // Assert
        $response->assertSessionHas('success', 'Nowa faktura została wystawiona.');

        $this->assertDatabaseHas('invoices', $invoiceData);
    }

    /**
     * @return void
     */
    public function test_can_edit_invoice()
    {
        // Arrange
        $invoice = Invoice::factory()->create();
        $updatedData = [
            'number' => fake()->unique()->numerify('INV-#####'),
            'buyer_nip' => fake()->numerify('1234567890'),
            'seller_nip' => fake()->numerify('1234567890'),
            'product_name' => fake()->word(),
            'amount' => fake()->numberBetween(1, 10),
            'product_price' => fake()->randomFloat(2, 1, 1000),
        ];

        // Act
        $response = $this->actingAs($this->user)->patch(route('invoices.update', $invoice), $updatedData);

        // Assert
        $response->assertSessionHas('success', 'Faktura została zaktualizowana.');

        $this->assertDatabaseHas('invoices', $updatedData);
    }

    /**
     * @return void
     */
    public function test_can_delete_invoice()
    {
        // Arrange
        $invoice = Invoice::factory()->create();

        // Act
        $response = $this->actingAs($this->user)->delete(route('invoices.destroy', $invoice));

        // Assert
        $response->assertSessionHas('success', 'Faktura została usunięta.');
    }
}