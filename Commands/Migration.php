<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends Command
{
    protected $commandName = 'make:migration';
    protected $commandDescription = "Create new table";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to greet?";

    protected $commandOptionName = "cap"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will greet in uppercase letters';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);

        if ($name) {
            $sql = "CREATE TABLE $name (
              id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              first_name VARCHAR (100) NOT NULL,
              last_name VARCHAR (100) NOT NULL,
              email VARCHAR (255) NOT NULL UNIQUE,
              password varchar (255) NOT NULL,
              email_verified varchar (255),
              access_token varchar (255),
              created_at TIMESTAMP DEFAULT now(),
              updated_at TIMESTAMP DEFAULT now()
            );";
            get_connection()->execute($sql);

            $text = 'Table created successfully';
        } else {
            $text = 'Table name is required';
        }

        if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}