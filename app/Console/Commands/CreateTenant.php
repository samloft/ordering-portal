<?php

namespace App\Console\Commands;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new tenant with the given name for the given domain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');

        $this->createTenant($name, $domain);

        $this->info("Tenant with name {$name} has been setup with domain {$domain}");
    }

    /**
     * @param $name
     * @param $domain
     *
     * @return \Hyn\Tenancy\Contracts\Hostname|\Hyn\Tenancy\Models\Hostname
     */
    public function createTenant($name, $domain)
    {
        $website = new Website;
        $website->uuid = $name;

        $website = app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname;
        $hostname->fqdn = $domain;

        $hostname = app(HostnameRepository::class)->create($hostname);

        app(HostnameRepository::class)->attach($hostname, $website);

        return $hostname;
    }
}
