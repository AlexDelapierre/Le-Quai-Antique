<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Question\Question;
use Doctrine\DBAL\Connection;

#[AsCommand(
  name: 'app:create-admin',
  description: 'Creates a new admin.',
  hidden: false,
  aliases: ['app:add-admin']
)]
class CreateAdminCommand extends Command
{
  /*https://symfony.com/doc/5.4/console.html#creating-a-command*/

  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'app:create-admin';

  // the command description shown when running "php bin/console list"
  protected static $defaultDescription = 'Creates a new admin.';

  private bool $requirePassword;

  private Connection $connection;


  public function __construct(Connection $connection, bool $requirePassword = false)
  {
    // best practices recommend to call the parent constructor first and
    // then set your own properties. That wouldn't work in this case
    // because configure() needs the properties set in this constructor
    $this->requirePassword = $requirePassword;
    $this->connection = $connection;

    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      // the command help shown when running the command with the "--help" option
      ->setHelp('This command allows you to create an administrator...')

      // configure an argument
      // ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
      // ->addArgument('email', InputArgument::REQUIRED, 'email of the administrator.')
      // ->addArgument('password', InputArgument::REQUIRED, 'password of the administrator.')
    ;
  }

    public function createAdminQuery(string $email, string $password, string $lastname, string $firstname, string $phoneNumber): void
  {
    $roles = '["ROLE_ADMIN"]';
    
    // Génère un hachage du mot de passe
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO user (email, roles, password, lastname, firstname, phone_number) VALUES ( :email , :roles , :passwordHash, :lastname , :firstname , :phoneNumber)';
    
    $this->connection->executeQuery($sql, ['email' => $email, 'roles' => $roles, 'passwordHash' => $passwordHash, 'lastname' => $lastname, 'firstname' => $firstname , 'phoneNumber' => $phoneNumber]);
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    // Question pour le nom
    $helper = $this->getHelper('question');
    $question = new Question('Entrez votre nom : ', '');
    $question->setNormalizer(function ($value) {
      // $value can be null here
      return $value ? trim($value) : '';
    });
    $lastname = $helper->ask($input, $output, $question);

    // Question pour le prénom
    $helper = $this->getHelper('question');
    $question = new Question('Entrez votre prénom : ', '');
    $question->setNormalizer(function ($value) {
      // $value can be null here
      return $value ? trim($value) : '';
    });
    $firstname = $helper->ask($input, $output, $question);

    // Question pour le téléphone
    $helper = $this->getHelper('question');
    $question = new Question('Entrez votre numéro de téléphone : ', '');
    $question->setNormalizer(function ($value) {
      // $value can be null here
      return $value ? trim($value) : '';
    });
    $phoneNumber = $helper->ask($input, $output, $question);

    // Question pour l'email
    $helper = $this->getHelper('question');
    $question = new Question('Entrez votre email : ', '');
    $question->setNormalizer(function ($value) {
      // $value can be null here
      return $value ? trim($value) : '';
    });
    $email = $helper->ask($input, $output, $question);
    
    // Question pour le mot de passe
    $helper = $this->getHelper('question');
    $question = new Question('Créez votre mot de passe : ');
    $question->setNormalizer(function ($value) {
      return $value ?? '';
    });
    $question->setValidator(function ($value) {
        if ('' === trim($value)) {
            throw new \Exception('The password cannot be empty');
        }
        return $value;
    });
    $question->setHidden(true);
    $question->setHiddenFallback(false);
    $password = $helper->ask($input, $output, $question);

    // Question pour la confirmation de mot de passe
    $helper = $this->getHelper('question');
    $question = new Question('Confirmer votre mot de passe : ');
    $question->setNormalizer(function ($value) {
      return $value ?? '';
    });
    $question->setValidator(function ($value) {
        if ('' === trim($value)) {
            throw new \Exception('The password cannot be empty');
        }
        return $value;
    });
    $question->setHidden(true);
    $question->setHiddenFallback(false);
    $passwordConfirm = $helper->ask($input, $output, $question);

    // // Vérification de la confirmation du mot de passe
    // if($password === $passwordConfirm) {
    //   // ... put here the code to create an admin
    //   $this->createAdminQuery($email, $password, $lastname, $firstname, $phoneNumber);
    // } else {
    //   // Nouvelle question pour la confirmation de mot de passe
    //   $helper = $this->getHelper('question');
    //   $question = new Question('La confirmation du mot de passe n\'est pas correcte, veuillez réessayer : ');
    //   $question->setNormalizer(function ($value) {
    //     return $value ?? '';
    //   });
    //   $question->setValidator(function ($value) {
    //       if ('' === trim($value)) {
    //           throw new \Exception('The password cannot be empty');
    //       }
    //       return $value;
    //   });
    //   $question->setHidden(true);
    //   $question->setHiddenFallback(false);
    //   $passwordConfirm = $helper->ask($input, $output, $question);
    // };
    
    // Vérification de la confirmation du mot de passe (Boucle infinie)
    while (true) {
      // Vérification de la confirmation du mot de passe
      if ($password === $passwordConfirm) {
          // ... put here the code to create an admin
          $this->createAdminQuery($email, $password, $lastname, $firstname, $phoneNumber);
          
          // Sortie de la boucle
          break;
      } else {
          // Nouvelle question pour la confirmation de mot de passe
          $helper = $this->getHelper('question');
          $question = new Question('La confirmation du mot de passe n\'est pas correcte, veuillez réessayer : ');
          $question->setNormalizer(function ($value) {
              return $value ?? '';
          });
          $question->setValidator(function ($value) {
              if ('' === trim($value)) {
                  throw new \Exception('The password cannot be empty');
              }
              return $value;
          });
          $question->setHidden(true);
          $question->setHiddenFallback(false);
          $passwordConfirm = $helper->ask($input, $output, $question);
      }
    }

    
    // outputs multiple lines to the console (adding "\n" at the end of each line)
    $output->writeln([
      'Admin Creator',
      '============',
      '',
    ]);

    // the value returned by someMethod() can be an iterator (https://php.net/iterator)
    // that generates and returns the messages with the 'yield' PHP keyword
    // $output->writeln($this->someMethod());

    // outputs a message followed by a "\n"
    $output->writeln('Bravo !');

    // outputs a message without adding a "\n" at the end of the line
    $output->write('Votre compte administrateur a été crée.');

    // retrieve the argument value using getArgument()
    // $output->writeln('Email: '.$input->getArgument('email'));
    // $output->writeln('Password: '.$input->getArgument('password'));

    // this method must return an integer number with the "exit status code"
    // of the command. You can also use these constants to make code more readable

    // return this if there was no problem running the command
    // (it's equivalent to returning int(0))
    return Command::SUCCESS;

    // or return this if some error happened during the execution
    // (it's equivalent to returning int(1))
    // return Command::FAILURE;

    // or return this to indicate incorrect command usage; e.g. invalid options
    // or missing arguments (it's equivalent to returning int(2))
    // return Command::INVALID
  }
}