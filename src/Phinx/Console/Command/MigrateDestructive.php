<?php namespace Phinx\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Migration\MigrationInterface;

class MigrateDestructive extends Migrate
{

	/**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('migrate:destructive')
             ->setDescription('Migrate only the database destructively')
             ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to migrate to')
             ->setHelp(
<<<EOT
The <info>migrate:destructive</info> command runs all available destructive migrations, optionally up to a specific version

<info>phinx migrate:destructive -e development</info>
<info>phinx migrate:destructive -e development -t 20110103081132</info>
<info>phinx migrate:destructive -e development -v</info>

EOT
             );
    }


	protected function doMigration($environment, $version)
	{
		$this->getManager()->migrate($environment, $version, MigrationInterface::TYPE_DESTRUCTIVE);
	}

}