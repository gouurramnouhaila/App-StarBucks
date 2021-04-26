<?php


namespace App\Handler;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface HandlerInterface
 * @package App\Handler
 */
interface HandlerInterface
{
    /**
     * @param Request $request
     * @param $data
     * @return bool
     */
    public function handle(Request $request,$data): bool ;

    /**
     * @return FormView
     */
    public function createView(): FormView ;
}