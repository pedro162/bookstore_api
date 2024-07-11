pipeline {
    agent any

    options {
        skipDefaultCheckout() // Skip the default checkout to customize it later
        timestamps() // Add timestamps to the console output
        buildDiscarder(logRotator(numToKeepStr: '10')) // Example build discarder configuration
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }
    	
    	stage('Install Dependencies') {
            steps {
                script {
                     // Example: Specify full path to Composer executable
                    sh '/usr/local/bin/composer install --no-ansi --no-interaction --no-progress --optimize-autoloader --ignore-platform-req=ext-dom --ignore-platform-req=ext-xml --ignore-platform-req=ext-curl'
                }
            }
        }
        
        stage('Run Tests') {
            steps {
                script {
                    // Example running PHPUnit tests
                    sh './vendor/bin/phpunit'
                }
            }
        }
        
        stage('Run Code Analysis') {
            steps {
                script {
                    // Example using PHP_CodeSniffer for code analysis
                    sh './vendor/bin/phpcs --standard=PSR2 app/'
                }
            }
        }
        
        stage('Deploy') {
            steps {
                script {
                    // Example deployment script using Laravel's Artisan command
                    sh 'php artisan deploy'
                }
            }
        }
    }

    post {
        always {
            // Clean up workspace after every build
            cleanWs()
        }
    }
}
