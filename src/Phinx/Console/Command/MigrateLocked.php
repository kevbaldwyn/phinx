<?php namespace Phinx\Console\Command;

use Illuminate\Filesystem\Filesystem;
use Phinx\Config\ConfigInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Phinx\Migration\MigrationInterface;

class MigrateLocked extends Migrate
{

    protected $filesystem;

    public function __construct($name = null, Filesystem $filesystem = null)
    {
        if(is_null($filesystem)) {
            $filesystem = new Filesystem();
        }

        $this->filesystem = $filesystem;
        parent::__construct($name);
    }

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

    protected function getLock()
    {
        // get the versions
        $lock = json_decode(
            $this->filesystem->get(dirname($this->getConfig()->getConfigFilePath()) . '/' . ConfigInterface::FILENAME_LOCK)
        );

        return [
            'constructive' => $lock->constructive->version,
            'destructive' => $lock->destructive->version
        ];
    }

	protected function doMigration($environment, $version)
	{
        // check version (we can't specify it so throw exception)
        if(!is_null($version)) {
            throw new \InvalidArgumentException('Cannot specify a version when migrating to a lock file');
        }

        $lock = $this->getLock();

        // migrate
        $this->getManager()->migrate($environment, $lock['constructive'], MigrationInterface::TYPE_CONSTRUCTIVE);
        $this->getManager()->migrate($environment, $lock['destructive'], MigrationInterface::TYPE_DESTRUCTIVE);
	}

}