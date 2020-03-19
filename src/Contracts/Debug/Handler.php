<?php
/**
 * Created by PhpStorm.
 * User: casperlai
 * Date: 2016/11/23
 * Time: 下午1:13
 */

namespace Casperlaitw\LaravelFbMessenger\Contracts\Debug;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class Handler implements ExceptionHandler
{
    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;
    /**
     * @var Debug
     */
    private $debug;

    /**
     * Handler constructor.
     * @param ExceptionHandler $exceptionHandler
     * @param Debug $debug
     */
    public function __construct(ExceptionHandler $exceptionHandler, Debug $debug)
    {
        $this->exceptionHandler = $exceptionHandler;
        $this->debug = $debug;
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     *
     * @return void
     * @throws Exception
     */
    public function report(Throwable $e)
    {
        // TODO: Implement report() method.
        if ($this->exceptionHandler !== null) {
            $this->exceptionHandler->report($e);
        }
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        // TODO: Implement render() method.
        $errors = [
            'message' => $e->getMessage(),
            'trace' => collect($e->getTrace())->map(function ($item) {
                return [
                    'file' => array_get($item, 'file'),
                    'line' => array_get($item, 'line'),
                    'method' => array_get($item, 'function'),
                ];
            })->toArray(),
        ];
        $this->debug->setError($errors)->broadcast();

        return $this->exceptionHandler->render($request, $e);
    }


    /**
     * Render an exception to the console.
     *
     * @param OutputInterface $output
     * @param Throwable $e
     * @return void
     */
    public function renderForConsole($output, Throwable $e)
    {
        // TODO: Implement renderForConsole() method.
        if ($this->exceptionHandler !== null) {
            $this->exceptionHandler->renderForConsole($output, $e);
        }
    }


    /**
     * Determine if the exception should be reported.
     *
     * @param \Exception $e
     *
     * @return bool
     */
    public function shouldReport(Throwable $e)
    {
        // TODO: Implement shouldReport() method.
        return true;
    }
}
