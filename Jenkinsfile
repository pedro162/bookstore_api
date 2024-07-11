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

        stage('Set Up Environment') {
            steps {
                script {

                    
                     // Debugging: Print the current working directory and its contents
                    sh 'pwd'
                    sh 'ls -la'

                    // Ensure the database directory exists
                    sh 'mkdir -p "/var/jenkins_home/workspace/Laravel Pipeline/database"'

                    // Debugging: Print the contents after directory creation
                    sh 'ls -la "/var/jenkins_home/workspace/Laravel Pipeline"'

                    // Create the SQLite database file
                    sh 'touch "/var/jenkins_home/workspace/Laravel Pipeline/database/database.sqlite"' 'touch "/var/jenkins_home/workspace/Laravel Pipeline/database/database.sqlite"'

                    sh 'cp .env.example .env'
                    sh 'php artisan key:generate'
                }
            }
        }

        stage('Prepare Database') {
            steps {
                script {
                    def databasePath = "${env.WORKSPACE}/database/database.sqlite"
                    sh "touch ${databasePath}"
                    sh "php artisan migrate --database=sqlite"
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
            junit '**/test-results.xml'
        }
    }
}
