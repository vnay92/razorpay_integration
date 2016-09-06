# Sample Razorpay API integration
Built on Lumen - a Microframework of PHP (because, Laravel would be an overkill and Slim doesn't have Dependency Injection :P)

## Requirements
 - Ubuntu >= 14.04
 - PHP >= 5.3
 - Composer for PHP
 - MySQL
 - Apache 2.4 /Nginx
 - Razorpay Keys

## Setup
### Script

    bash setup.sh
or

    ./setup.sh

### Manually
Follow the commands in `script.sh` ;)

## Structure
A variant of the Gateways, Repository pattern.

UI/API -> Routes -> Middleware -> Controller -> Gateways -> Repositories -> Model -> DB

### Points to note
 - Point Apache to the `public/` folder. (You might want to create a new `.conf` file)
 - All APIs have a common middleware
 - Make sure you have the `.env` file set up properly
 - Gateways have the business logic
