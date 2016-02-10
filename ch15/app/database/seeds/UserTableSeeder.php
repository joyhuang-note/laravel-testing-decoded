<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        $user = new User;
        $user->email = 'jeffrey@envato.com';
        $user->password = Hash::make('1234');
        $user->save();
    }

}