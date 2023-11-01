    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->unsignedBigInteger('office_id');
            $table->string('number');
            $table->date('ordinance_date')->nullable();
            $table->string('agent')->nullable();
            $table->string('organization_company')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->date('trip_start');
            $table->date('trip_end');
            $table->date('payment_date')->nullable();
            $table->decimal('unit_price');
            $table->decimal('quantity');
            $table->decimal('amount')->nullable();
            $table->text('justification')->nullable();
            $table->text('historic')->nullable();
            $table->text('information')->nullable();
            $table->string('slug');
            $table->timestamps();
            
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dailies');
    }
};
