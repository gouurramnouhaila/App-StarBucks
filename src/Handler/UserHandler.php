<?php


namespace App\Handler;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    protected function getFormType(): string
    {
        return UserType::class;
    }

    /**
     * @inheritDoc
     * @param $data User
     */
    protected function process($data): void
    {
        $data->setPassword($this->passwordEncoder->encodePassword($data,$data->getPassword()));
        $this->manager->persist($data);
        $this->manager->flush();
    }
}