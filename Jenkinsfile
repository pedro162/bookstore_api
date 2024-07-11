pipeline{
	agent any

	environment {
		HOME = 'var/www/html/bookstore_api'
	}

	stages {
		stage('Checkout'){
			steps {
				checkout scm
			}
		}

		stage('Install Dependencies'){
			steps{
				sh 'composer install --no-ansi --no-interaction --no-progress --no-scripts'
			}
		}

		stage('Run Tests'){
			steps{
				sh './vendor/bin/phpunit'
			}
		}

		stage('Run Code Analysis'){
			steps{
				sh './vendor/bin/php -l app'
				// Add more steps as needed for code analysis tools like PHP_CodeSniffer, etc.
			}
		}

		stage('Deploy'){
			steps{
				sh 'php artisan deploy'
			}
		}
	}

	options{
		skipDefaultCheckout()
		// Add the following option to include crumb in HTTP requests
        ansiColor('xterm')
        buildDiscarder(logRotator(artifactDaysToKeepStr: '', artifactNumToKeepStr: '', daysToKeepStr: '', numToKeepStr: '3'))
	} 

}