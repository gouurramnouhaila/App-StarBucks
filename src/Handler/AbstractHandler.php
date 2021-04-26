<?php


namespace App\Handler;



use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractHandler implements HandlerInterface
{

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var FormFactoryInterface
     */
    private  $formFactory;

    private  $container;

    /**
     * @required
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }


    /**
     * @return string
     */
    abstract protected function getFormType(): string ;

    /**
     * @param $data
     */
    abstract protected function process($data): void ;


    public function handle(Request $request, $data): bool
    {
        $this->form = $this->formFactory->create($this->getFormType(),$data,[])->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->process($data);
            return true;
        }

        return  false;
    }

    public function createView(): FormView
    {
        return  $this->form->createView();
    }

    public function getForm() {
        return $this->form;
    }
}