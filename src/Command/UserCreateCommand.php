<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'user:create';
    private $userRepository;
    private $objectManager;
    private $validator;
    private $io;
    private $passwordEncoder;

    /**
     * UserCreateCommand constructor.
     * @param UserRepository $userRepository
     * @param ObjectManager $objectManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserRepository $userRepository,
        ObjectManager $objectManager,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->objectManager = $objectManager;
        $this->validator = Validation::createValidator();
        $this->passwordEncoder = $passwordEncoder;

    }

    protected function configure()
    {
        $this
            ->setDescription('Create an user')
            ->setHelp('This command allow you to create an user.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('Create an user');

        $username = $this->io->ask('username of the user ', 'MrNobody', function ($input) {
            if($this->userExist(['username' => $input])) {
                throw new \RuntimeException('This username is already used');
            }
            return (string) $input;
        });

        $email = $this->io->ask('email of the user ', 'mrnobody@gmail.com', function ($input) {
            if($this->userExist(['email' => $input])) {
                throw new \RuntimeException('This email is already used');
            } else {
                $this->validate(new Assert\Email(['checkMX'=>true]), $input);
            }
            return (string) $input;
        });

        $lastName = $this->io->ask('last name of the user ', 'no', function ($input) {
            return (string) $input;
        });

        $firstName = $this->io->ask('first name of the user ', 'body', function ($input) {
            return (string) $input;
        });

        $age = $this->io->ask('age ', 18, function ($input) {
            if(!is_numeric($input)) {
                throw new \RuntimeException("$input is not numeric");
            }
            return (int) $input;
        });

        $pro = $this->io->ask('is pro ', false, function ($input) {
            $this->validate(new Assert\Type('boolean'), $input);
            return (bool) $input;
        });

        $roles = $this->io->ask('roles of the user (separated by ,) ', 'ROLE_USER,', function ($input) {
            $this->validate(new Assert\Regex(['pattern' => '/[\s,]+/']), $input);
            return explode(',', $input);
        });

        $password = $this->io->askHidden('password of the user ', function ($password) {
            return (string) $password;
        });

        $params = [
            'setUsername' =>  $username,
            'setEmail' => $email,
            'setLastname' => $lastName,
            'setFirstname' => $firstName,
            'setAge' => $age,
            'setPro' => $pro,
            'setRoles' => $roles,
            'setPassword' => $password
        ];

        $this->createUser($params);

        $this->io->success("User $username created");
    }

    private function createUser($params) {
        $user = new User();
        foreach ($params as $setter => $value) {
            if($setter == 'setPassword') {
                $value = $this->passwordEncoder->encodePassword($user, $value);
            }
            $user->$setter($value);
        }
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    private function validate($constraints, $subject) {
        $errors = $this->validator->validate(
            $subject,
            $constraints
        );

        if (0 !== count($errors)) {
            $errorsMessage = '';
            foreach ($errors as $error) {
                $errorsMessage .= $error->getMessage() . PHP_EOL;
            }
            throw new \RuntimeException($errorsMessage);
        }
    }

    private function userExist($param) : bool {
        if($this->userRepository->findOneBy($param))
            return true;
        return false;
    }
}
