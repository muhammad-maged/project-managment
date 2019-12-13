<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('dependent_tasks')->nullable();
            $table->string('estimated_duration')->nullable();
            $table->string('actual_duration')->nullable();
            $table->integer('worker_id')->nullable()->unsigned();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('type');
            $table->integer('parent_id')->nullable()->unsigned();

            $table->foreign('worker_id')
                ->references('id')->on('workers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('parent_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
