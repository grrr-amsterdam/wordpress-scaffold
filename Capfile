# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

# Load tasks from gems
require 'capistrano/composer'

# Load Git SCM plugin
require 'capistrano/scm/git'
install_plugin Capistrano::SCM::Git

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
# Customize this path to change the location of your custom tasks.
Dir.glob('config/deploy/tasks/*.cap').each { |r| import r }
