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
                    // Ensure the database directory exists
                    sh 'mkdir -p "/var/jenkins_home/workspace/Laravel_Pipeline/database"'
                    
                    // Create the SQLite database file if not exists
                    def databasePath = "${env.WORKSPACE}/database/database.sqlite"
                    sh "if [ ! -f ${databasePath} ]; then touch ${databasePath}; fi"
                    
                    // Copy .env.example if .env doesn't exist
                    sh 'cp -n .env.example .env || true'
                    
                    // Generate Laravel application key
                    sh 'php artisan key:generate'
                }
            }
        }

        stage('Prepare Database') {
            steps {
                script {
                    // Ensure the database migrations run against SQLite
                    sh "php artisan migrate --database=sqlite"
                }
            }
        }
        
        stage('Run Tests') {
            steps {
                script {
                    // Example running PHPUnit tests and saving results
                    sh './vendor/bin/phpunit --log-junit ./build/logs/test-results.xml'
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
                    // Placeholder for deployment script using Laravel's Artisan command
                    sh 'php artisan deploy'
                }
            }
        }
    }

    post {
        always {
            // Clean up workspace after every build
            cleanWs()
            // Archive JUnit test results
            junit '**/test-results.xml'
        }
    }
}
