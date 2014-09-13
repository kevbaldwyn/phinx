<?php namespace Phinx\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Migration\MigrationInterface;

class MigrateConstructive extends Migrate
{

	/**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('migrate:constructive')
             ->setDescription('Migrate only the database constructively')
             ->setHelp(
<<<EOT
The <info>migrate:constructive</info> command runs all available constructive migrations, optionally up to a specific version

<info>phinx migrate:constructive -e development</info>
<info>phinx migrate:constructive -e development -t 20110103081132</info>
<info>phinx migrate:constructive -e development -v</info>

EOT
             );
    }


	protected function doMigration($environment, $version)
	{
		$this->getManager()->migrate($environment, $version, MigrationInterface::TYPE_CONSTRUCTIVE);
	}

}