# Load dotenv
require 'dotenv'
Dotenv.load

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

# Includes Composer tasks
require 'capistrano/composer'

# Load Git SCM plugin
require 'capistrano/scm/git'
install_plugin Capistrano::SCM::Git

# Load Slackistrano
require 'slackistrano/capistrano'
require_relative 'config/deploy/lib/custom_messaging'

# Load custom tasks
Dir.glob('config/deploy/tasks/**/*.cap').each { |r| import r }
