<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Promise;

use React\Promise\Deferred;
use React\Promise\PromiseInterface;

/**
 * Class holding an example of how to use Promises.
 */
class MyPromise
{
    /**
     * Resolves a promise and updates its value.
     */
    public function __construct()
    {
        $this->helloWorld()->then(function ($result) {
            echo "Promise result: $result\n";
        });
    }

    /**
     * Helper function that creates a promise.
     *
     * @return PromiseInterface
     */
    private function helloWorld(): PromiseInterface
    {
        $deferred = new Deferred();
        $promise  = $deferred->promise();
        $deferred->resolve('Hello world.');

        return $promise;
    }
}