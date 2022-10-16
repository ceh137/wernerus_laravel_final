<?php

namespace App\Console\Commands;

use App\Jobs\ParseOrder;
use App\Mail\PasswordMade;
use App\Models\AppToOrder;
use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\File;
use App\Models\Order;
use App\Models\OrderPrice;
use App\Models\Route;
use App\Models\Type;
use App\Models\User;
use App\Models\WhoPays;
use App\Services\FileService;
use App\Services\GoogleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ParseOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing Orders from Google Sheets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $gog = new GoogleService();
        $data_full =  $gog->readGoogleSheet();

//        echo '<pre>'; var_dump($data[0]); echo '</pre>';

        foreach ($data_full as $data) {
            if ($data === $data_full[0]) {
                continue;
            } elseif ($data[2] == '') {
                continue;
            }
            ParseOrder::dispatch($data);


        }
        return 0;
    }
}
