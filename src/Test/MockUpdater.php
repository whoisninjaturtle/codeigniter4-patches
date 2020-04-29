<?php namespace Tatter\Patches\Test;

use CodeIgniter\Config\BaseConfig;
use Tatter\Patches\Exception\UpdateException;
use Tatter\Patches\Interfaces\UpdaterInterface;

/**
 * Class MockUpdater
 *
 * Manipulates random files from vendor to simulate running
 * an update. Tracks changes so they are available for comparison.
 */
class MockUpdater implements UpdaterInterface
{
	/**
	 * Array of relative paths to files changed by updating
	 *
	 * @var array|null
	 */
	public $changedFiles;

	/**
	 * Array of relative paths to files added by updating
	 *
	 * @var array|null
	 */
	public $addedFiles;

	/**
	 * Array of relative paths to files deleted by updating
	 *
	 * @var array|null
	 */
	public $deletedFiles;

	/**
	 * Manipulate random files in vendor.
	 *
	 * @param BaseConfig $config
	 *
	 * @throws UpdateException
	 */
	public function run(BaseConfig $config = null)
	{
		// Get all paths in ROOTPATH/vendor
		$paths = get_filenames($config->rootPath . 'vendor', null, true);

				
	}
}
