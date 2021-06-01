<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // 開発用ユーザーを定義
        // App\User::create([
        //     'name' => 'さとみ',
        //     'email' => 'end.indigo@gmail.com',
        //     'password' => Hash::make('nwzy4121'), // この場合、「my_secure_password」でログインできる
        //     'remember_token' => str_random(10),
        // ]);

        // モデルファクトリーで定義したテストユーザーを 20 作成
        factory(App\User::class, 20)->create();
    }
}
