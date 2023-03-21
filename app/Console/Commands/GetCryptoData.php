<?php

namespace App\Console\Commands;

use App\Services\CryptoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class GetCryptoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:get-data {quantity=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch crypto data from API and fill particular "cryptos" DB table';

    /**
     * Execute the console command.
     */

    public function __construct(private readonly CryptoService $userService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $quantity = $this->argument('quantity');
        $this->info($quantity);

        $validator = Validator::make([
            'quantity' => $quantity,
        ], [
            'quantity' => ['integer', 'min:100', 'max:1000']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }

        $this->userService->fillCryptoDataTable($this->argument('quantity'));
        $this->info('"cryptos" table was filled with data successfully!');
    }
}
