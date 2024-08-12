<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Phone;
use App\Models\Emails;
use App\Models\Links;
use App\Models\Dates;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
    
        $user = User::create([
            'first_name' => 'Иван',
            'last_name' => 'Иванов',
            'notes' => 'sgdf;g;dfjhg;dfhg;jdfhg'
        ]);

        Phone::create([
            'user_id' => $user->id,
            'number' => '1234567890',
            'type' => 'mobile'
        ]);

        Phone::create([
            'user_id' => $user->id,
            'number' => '0987654321',
            'type' => 'work'
        ]);

        
        Emails::create([
            'user_id' => $user->id,
            'email' => 'ivan@example.com',
            'type' => 'personal'
        ]);

        Emails::create([
            'user_id' => $user->id,
            'email' => 'ivan.ivanov@work.com',
            'type' => 'work'
        ]);
        Links::create([
            'user_id' => $user->id,
            'link' => 'wqeqwe.com',
            'type' => 'website'
        ]);
        Links::create([
            'user_id' => $user->id,
            'link' => 'qwewqe.com',
            'type' => 'telegram'
        ]);
        Dates::create([
            'user_id' => $user->id,
            'date' => '1999-01-01',
            'type' => 'свадьба'
        ]);
        Dates::create([
            'user_id' => $user->id,
            'date' => '2004-01-01',
            'type' => 'кываыва'
        ]);
        Company::create([
            'user_id' => $user->id,
            'name' => 'Компания авав',
            'address' => 'Адрес фвыфы',
        ]);

        Company::create([
            'user_id' => $user->id,
            'name' => 'бизнес ',
            'address' => 'Улица фаы',
        ]);
    }
}
