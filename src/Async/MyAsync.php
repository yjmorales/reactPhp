<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Async;

use App\Core\ApiClient;
use GuzzleHttp\Exception\GuzzleException;
use React\EventLoop\Loop;
use React\Promise\Deferred;
use function React\Async\{async, await};
use function React\Promise\Timer\{sleep};
use function React\Promise\{all};

/**
 * Class responsible to implement examples of Asynchronously code blocks in PHP using ReactPHP library.
 *
 * @link https://reactphp.org/async/
 * @link https://reactphp.org/promise/
 * @link https://reactphp.org/event-loop
 */
class MyAsync
{
    /**
     * @var ApiClient
     */
    private ApiClient $apiClient;

    /**
     * All examples are held by a specific public method. The method is call in the constructor for instructive
     * purposes.
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;

        // Retrieves the data from the API asynchronously
        $this->asyncApi();

        // Retrieves the data from the API synchronously
        // $this->noAsyncApi();


        // Prints letters in order. a,b,c
        // $this->printLetters();
    }

    /**
     * Function used to show how a synchronous code works in PHP. Default behaviour.
     * It calls 2 API Endpoints , getItems and getEmployee. After each call there are code portions that are executed
     * AFTER the previous call is made. It's blocked by default.
     *
     * The steps of this code are:
     * 1. Get Items
     * 2. Portion of code. (In this case something is printed by `echo`, but it may be a method execution, etc.)
     * 3. Get Employees
     * 4. Portion of code. (In this case something is printed by `echo`, but it may be a method execution, etc.)
     * 5. A final message is render after all is done.
     *
     * @return void
     */
    public function noAsyncApi(): void
    {
        // 1)
        $this->_getItems();               // Get Items
        echo "Sync: Searched Items\n";    // Portion of code after Item are retrieved

        // 2)
        $this->_getEmployees();            // Get Employees
        echo "Sync: Searched Employee\n"; // Portion of code after Employees are retrieved

        // 3)
        echo "Sync: All done\n";          // Portion of code after Items & Employee are retrieved

        // The result will be
        // Sync: Searched Items
        // Sync: Searched Employee
        // Sync: All done
    }

    /**
     * Function used to show how an asynchronous code works in PHP using ReactPHP.
     * It's used loop event, promises and async components.
     *
     * A promise is created to handle the items retrieving.
     * A promise is created to handle the employee retrieving.
     * Both of them are queued into the timer event loop queue.
     * After the promises are queued a portion of code is placed right after that clauses.
     * Both of them are executed.
     *
     * @return void
     */
    public function asyncApi(): void
    {
        /*
         * Promise for retrieving Items
         */
        $promiseItems = ($deferredItems = new Deferred())->promise();
        $promiseItems->then(function () {
            return $this->_getItems();
        })->done(function ($items) {
            // Do something with $items
        });

        /*
         * Promise for retrieving Employees
         */
        $promiseEmployee = ($deferredEmployee = new Deferred())->promise();
        $promiseEmployee->then(function () {
            return $this->_getEmployees();
        })->done(function ($employees) {
            // Do something with $employees
        });

        /*
         * Invokes on the future tick of the event loop. Asynchronously get Items
         */
        Loop::futureTick(
            async(function () use ($promiseItems, $deferredItems) {
                $deferredItems->resolve();
                await($promiseItems);
            })
        );

        // Portion of code to be executed as normal. It is not blocked by the above clause because the
        // above code is executed async
        echo "Async: Search Items\n";

        /*
         * Invokes on the future tick of the event loop. Asynchronously get Employees
         */
        Loop::futureTick(
            async(function () use ($promiseEmployee, $deferredEmployee) {
                $deferredEmployee->resolve();
                await($promiseEmployee);
            })
        );

        // Portion of code to be executed as normal. It is not blocked by the above clause because the
        // above code is executed async
        echo "Async: Searched Employee\n";


        // After all promises are resolved all will be done.
        all([$promiseItems, $promiseEmployee])->done(function () {
            echo "Async: All done\n";
        });

        // The result will be:
        // Async: Search Items
        // Async: Searched Employee
        // ...... The items and employees are retrieved Asynchronously
        // Async: All done
    }

    /**
     *  Helper function to print letters in order. a,b,c
     *
     * @return void
     */
    public function printLetters(): void
    {
        Loop::addTimer(1, async(function () {
            echo "a\n";
            await(sleep(2));
            echo "c\n";
        }));
        Loop::addTimer(1, function () {
            echo "b\n";
        });
    }

    /**
     * Helper function to retrieve items
     *
     * @return array
     * @throws GuzzleException
     */
    private function _getItems(): array
    {
        return $this->apiClient->getItemList();
    }

    /**
     * Helper function to retrieve employees
     *
     * @return array
     * @throws GuzzleException
     */
    private function _getEmployees(): array
    {
        return $this->apiClient->getEmployeeList();
    }
}