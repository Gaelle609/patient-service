<?php

namespace App\Console\Commands;

use Firebase\JWT\JWT;
use Illuminate\Console\Command;

class GenerateFakeToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:generate-fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère un token JWT simulé pour un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $payload = [
            'id' => 1,
            'email' => 'gaelle@example.com',
            'name' => 'gaelle',
            'permissions' => ['create_exam', 'update_exam'],
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        $this->info("Token JWT simulé :");
        $this->line($jwt);
    }
}
