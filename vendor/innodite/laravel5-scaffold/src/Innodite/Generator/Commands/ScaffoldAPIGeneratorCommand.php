<?php namespace Innodite\Generator\Commands;

use Innodite\Generator\CommandData;
use Innodite\Generator\Generators\API\RepoAPIControllerGenerator;
use Innodite\Generator\Generators\Common\MigrationGenerator;
use Innodite\Generator\Generators\Common\ModelGenerator;
use Innodite\Generator\Generators\Common\RepositoryGenerator;
use Innodite\Generator\Generators\Common\RequestGenerator;
use Innodite\Generator\Generators\Common\RoutesGenerator;
use Innodite\Generator\Generators\Scaffold\RepoViewControllerGenerator;
use Innodite\Generator\Generators\Scaffold\ViewGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ScaffoldAPIGeneratorCommand extends BaseCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'innodite.generator:scaffold_api';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a full CRUD for given model with initial views and APIs';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD_API);
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		parent::handle();

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		$requestGenerator = new RequestGenerator($this->commandData);
		$requestGenerator->generate();

		$repositoryGenerator = new RepositoryGenerator($this->commandData);
		$repositoryGenerator->generate();

		$repoControllerGenerator = new RepoAPIControllerGenerator($this->commandData);
		$repoControllerGenerator->generate();

		$viewsGenerator = new ViewGenerator($this->commandData);
		$viewsGenerator->generate();

		$repoControllerGenerator = new RepoViewControllerGenerator($this->commandData);
		$repoControllerGenerator->generate();

		$routeGenerator = new RoutesGenerator($this->commandData);
		$routeGenerator->generate();

		if($this->confirm("\nDo you want to migrate database? [y|N]", false))
			$this->call('migrate');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array_merge(parent::getArguments(), []);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return array_merge(parent::getOptions(), []);

	}
}