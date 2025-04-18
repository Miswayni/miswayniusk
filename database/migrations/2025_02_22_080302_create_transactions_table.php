<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('recipient_id')->nullable()->constrained('users');
    $table->enum('type', ['top_up', 'withdraw', 'transfer']);
    $table->decimal('amount', 15, 2);
    $table->string('status')->default('success');
    $table->string('description')->nullable();
    $table->timestamps();

    });
    }
    
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
