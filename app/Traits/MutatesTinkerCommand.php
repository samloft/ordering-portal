<?php

namespace App\Traits;

use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Database\Connection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputOption;

trait MutatesTinkerCommand
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var WebsiteRepository
     */
    private $websites;

    public function __construct()
    {
        parent::__construct();
        $this->setName('tenancy:' . $this->getName());
        $this->websites = app(WebsiteRepository::class);
        $this->connection = app(Connection::class);
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Hyn\Tenancy\Exceptions\ConnectionException
     */
    public function handle()
    {
        $website_id = $this->option('website_id');
        try{
            $website = $this->websites->query()->where('id', $website_id)->firstOrFail();
            $this->connection->set($website);
            $this->info('Running Tinker on website_id: ' . $website_id);

            parent::handle();

            $this->connection->purge();
        } catch (ModelNotFoundException $e) {
            throw new RuntimeException(sprintf('The tenancy website_id=%d does not exist.', $website_id));
        }
    }

    protected function getOptions()
    {
        return array_merge([$this->addWebsiteOption()], parent::getOptions());
    }

    protected function addWebsiteOption()
    {
        return ['website_id', null, InputOption::VALUE_REQUIRED, 'The tenancy website_id (not uuid) to tinker specifically.', null];
    }
}
