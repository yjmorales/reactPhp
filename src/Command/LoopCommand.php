<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Command;

use App\Async\MyAsync;
use App\Core\ApiClient;
use App\Loop\MyLoop;
use App\Promise\MyPromise;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command used as front controller to execute the implemented resources:
 * - Async
 * - Loop
 * - Promises.
 */
class LoopCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected static $defaultName = 'app:loop';

    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient, string $name = null)
    {
        parent::__construct($name);

        $this->apiClient = $apiClient;
    }

    /**
     * The resources use can be done by uncommenting the respective line.
     *
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Runs and stops a loop event.
        // $this->runAndStopLoop();

        // Getting data asynchronously.
        $this->getDataAsync();

        return self::SUCCESS;
    }

    /**
     * By instantiating MyLoop it's executed the examples held by that class.
     * Further info go to: src\App\Loop\MyLoop
     *
     * @return void
     */
    private function runAndStopLoop(): void
    {
        new MyLoop();
    }

    /**
     * By instantiating MyAsync it's executed the examples held by that class.
     * Further info go to: src\App\Async\MyAsync
     *
     * @return void
     */
    private function getDataAsync(): void
    {
        new MyAsync($this->apiClient);
    }

    /**
     * By instantiating MyPromise it's executed the examples held by that class.
     * Further info go to: src\App\Promise\MyPromise
     *
     * @return void
     */
    private function promise(): void
    {
        new MyPromise();
    }
}