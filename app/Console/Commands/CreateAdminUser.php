<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar um utilizador admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Nome do admin?');
        $email = $this->ask('Email do admin?');
        $password = $this->secret('Senha do admin?');

        if (User::where('email', $email)->exists()) {
            $this->error('Este email já existe!');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Admin criado com sucesso!');
        return 0;
    }
}
