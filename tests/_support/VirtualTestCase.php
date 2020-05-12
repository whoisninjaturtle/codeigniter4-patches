<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use org\bovigo\vfs\vfsStream;

class VirtualTestCase extends CIUnitTestCase
{
	/**
	 * @var vfsStream
	 */
	protected $root;

	/**
	 * @var string  Path to the virtual project
	 */
	protected $project;

	/**
	 * @var string  Path to the virtual pacakge source
	 */
	protected $source;

	public function setUp(): void
	{
		parent::setUp();

		// Create the VFS
		$this->root = vfsStream::setup();
		vfsStream::copyFromFileSystem(SUPPORTPATH . 'MockProject', $this->root);

		defined('VIRTUALPATH') || define('VIRTUALPATH', $this->root->url() . '/');
		$this->project = VIRTUALPATH;
		$this->source  = VIRTUALPATH . 'vendor/testsource/';

		// Standardize testing config
		$this->config           = new \Tatter\Patches\Config\Patches();
		$this->config->basePath = $this->project . 'writable/patches';
		$this->config->rootPath = $this->project;
		$this->config->updater  = 'Tatter\Patches\Test\MockUpdater';
	}

	public function tearDown(): void
	{
		parent::tearDown();

		$this->root = null;
	}

	/**
	 * Clean up files generated from Composer update/install
	 */
	protected function removeComposerFiles(): void
	{
		// Remove any files created
		delete_files($this->config->rootPath . 'vendor/tatter', true);
		delete_files($this->config->rootPath . 'vendor/composer', true);

		if (is_dir($this->config->rootPath . 'vendor/tatter'))
		{
			rmdir($this->config->rootPath . 'vendor/tatter');
		}
		if (is_dir($this->config->rootPath . 'vendor/composer'))
		{
			rmdir($this->config->rootPath . 'vendor/composer');
		}
		if (is_file($this->config->rootPath . 'composer.lock'))
		{
			unlink($this->config->rootPath . 'composer.lock');
		}
		if (is_file($this->config->rootPath . 'vendor/autoload.php'))
		{
			unlink($this->config->rootPath . 'vendor/autoload.php');
		}
	}

	/**
	 * Composer will not run on VFS so this provides a way to mock package updates.
	 */
	protected function mockUpdate(): void
	{
		// Change a file
		file_put_contents($this->source . 'lorem.txt', 'All your base are belong to us.');

		// Add a file
		mkdir($this->source . 'src', 0700);
		file_put_contents($this->source . 'src/definition.json', '{"packages": {"tatter": "Patches"}}');

		// Remove a file
		unlink($this->source . 'images/cat.jpg');
	}
}
