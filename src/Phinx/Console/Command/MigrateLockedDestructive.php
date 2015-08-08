<?php namespace Phinx\Console\Command;

use Phinx\Config\ConfigInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Migration\MigrationInterface;

class MigrateLockedDestructive extends MigrateLocked
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('migrate:locked:destructive')
            ->setDescription('Migrate the database to the local phinx.lock file version destructively')
            ->setHelp(
                <<<EOT
                The <info>migrate:locked:destructive</info> command runs all available destructive migrations, to the locked version defined by the phinx.lock file

<info>phinx migrate:locked:destructive -e development</info>

EOT
            );
    }

    protected function doMigration($environment, $version)
    {
        // check version (we can't specify it so throw exception)
        if(!is_null($version)) {
            throw new \InvalidArgumentException('Cannot specify a version when migrating to a lock file');
        }

        $lock = $this->getLock();

        // migrate
        $this->getManager()->migrate($environment, $lock['constructive'], MigrationInterface::TYPE_CONSTRUCTIVE, false);
    }

}