<?php namespace Phinx\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Migration\MigrationInterface;

class MigrateLocked extends Migrate
{

	/**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('migrate:locked:all')
             ->setDescription('Migrate the database to the local phinx.lock file version')
             ->setHelp(
<<<EOT
The <info>migrate:locked:all</info> command runs all available constructive and destructive migrations, to the locked version defined by the phinx.lock file

<info>phinx migrate:locked:all -e development</info>

EOT
             );
    }


	protected function doMigration($environment, $version)
	{
		$this->getManager()->migrate($environment, $version, MigrationInterface::TYPE_CONSTRUCTIVE);
	}

}