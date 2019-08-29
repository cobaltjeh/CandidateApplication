# CandidateApplication

- Used symfony framework, since the console helpers are a great help for making command line applications.
- The autowiring in the service container, makes adding and extending classes easy.
- Did not include the whole framework and used a custom microkernel to keep things clean.
- Added a logger using Monolog, so we can add debug messages. 
In the future it is easy to add an extra handler to push message to a logging system (Syslog, Elasticsearch).


## Installation

Clone the project to download its contents:

```bash
cd Projects
git clone https://github.com/cobaltjeh/CandidateApplication.git
```

Use Composer to install all dependencies:

```bash
cd CandidateApplication/
composer install
```

##Run the application:

### Simple script

(As the first parameter, provice the output filename.)

```bash
bin/simple.php test.csv
```

### Symfony Console

(For details about using the command use the following command.)

```bash
app/console app:saleswages --help
```
