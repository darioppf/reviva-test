# reviva-test

This is developed as a symfony command to generate receipt from shopping basket files for demo purposes.

## Installation

Use docker to create an image for this package before using it, run the above command from the project directory:

```bash
docker build . -t reviva-test
```

## Usage

```bash
docker container run -ti reviva-test
```
From the running container switch to /app directory and run:

```bash
php bin/console reviva:process-shopping-baskets test/shoppingBaskets /tmp
```
This command will read shopping basket files inside test/shoppingBaskets and generate the corresponding receipts in /tmp, receipts would be also printed to stdout

## Testing
Test the program by running the above command inside the container from /app directory
```bash
php vendor/behat/behat/bin/behat
```

## License
[LGPL](https://opensource.org/licenses/LGPL-3.0)
