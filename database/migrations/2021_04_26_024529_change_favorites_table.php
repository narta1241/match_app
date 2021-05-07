<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
          $table->renameColumn('favoritting_user_id', 'user_id');
          $table->renameColumn('favorited_user_id', 'profile_id');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favorites', function (Blueprint $table) {
          $table->renameColumn('user_id', 'favoritting_user_id');
          $table->renameColumn('profile_id', 'favorited_user_id');
       });
    }
}
