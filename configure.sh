
# Turn on echoing, error-reporting.
#set -eux -o pipefail

environment="dev"

if [ "$#" -ge 1 ]; then
    environment=$1
fi

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
DIR_BASE=`dirname ${DIR}`
DIR_GEN=${DIR_BASE}/autogen

mkdir ${DIR_GEN}

configurate=${DIR_BASE}/content/vendor/danack/configurator/bin/configurate

if [[ $environment == 'dev' ]]
then
	${configurate} -p ${DIR}/scripts/phpfpm.php ${DIR}/templates/php-fpm.conf.dev.php ${DIR_GEN}/php-fpm.conf env
	${configurate} -p ${DIR}/scripts/nginx.php ${DIR}/templates/nginx.conf.dev.php ${DIR_GEN}/nginx.conf env
	${configurate} -p ${DIR}/scripts/wordpress.php  ${DIR}/templates/wp-config.php.dev.php ${DIR_GEN}/wp-config.php env
else
	echo 'Production Work In Progress'
fi

# Convert the ini file to be in the PHP-FPM format
#bin/fpmconv autogen/php.ini autogen/php.fpm.ini

# Link the generated files to where they need to be on the system.
# Not needed for example
# sh autogen/addConfig.sh
#echo "skipped running autogen/addConfig.sh as this is an example."

#bin/genenv -p example/config.php example/envRequired.php autogen/appEnv.php $environment

echo "Done. Generated files are in autogen directory: ${DIR_GEN}"