<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Loop;

use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

/**
 * Class responsible to implement examples of Loop Event component
 */
class MyLoop
{
    /**
     * @var TimerInterface
     */
    private TimerInterface $_periodicTimer;

    /**
     * Holds the number of time the timer is executed.
     *
     * @var int
     */
    private int $_count = 0;

    /**
     * The examples are implemented by the methods. If you want to play with them please uncomment them.
     */
    public function __construct()
    {
        // $this->tick();
        // $this->stop();
        $this->futureTick();
    }

    /**
     * Creates a periodic timer.
     *
     * @return void
     */
    public function tick(): void
    {
        $seconds              = 0.5;
        $this->_periodicTimer = Loop::addPeriodicTimer($seconds, function () use ($seconds) {
            $this->_count++;
            echo "This is a TICK every $seconds" . PHP_EOL;
        });
    }

    /**
     * Stops a periodic timer.
     *
     * @return void
     */
    public function stop(): void
    {
        $seconds = 5;
        Loop::addTimer($seconds, function () use ($seconds) {
            Loop::cancelTimer($this->_periodicTimer);
            echo "TICK stopped at $seconds seconds" . PHP_EOL;
            echo "Total ticks = $this->_count" . PHP_EOL;
        });
    }

    /**
     * This function listen the next event loop tick and execute some code.
     * This example prints a,b,c in order.
     *
     * @return void
     */
    public function futureTick(): void
    {
        $loop = Loop::get();
        $loop->futureTick(function () {
            echo 'b';
        });
        $loop->futureTick(function () {
            echo 'c';
        });
        echo 'a';
    }
}

