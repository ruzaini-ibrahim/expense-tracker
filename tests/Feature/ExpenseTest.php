<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Expense;

class ExpenseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateExpense()
    {
        $User = User::all()->first();
        dd(env('TESTING_DB_DATABASE'));
        // dd($User);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
