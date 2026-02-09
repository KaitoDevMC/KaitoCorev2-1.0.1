#!/bin/bash
DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
cd "$DIR"

# Automatically restart the server
DO_LOOP="no"

while getopts "p:f:l" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
		f)
			POCKETMINE_FILE="$OPTARG"
			;;
		l)
			DO_LOOP="yes"
			;;
		\?)
			break
			;;
	esac
done

# ===============================
# PHP BINARIO
# ===============================
if [ "$PHP_BINARY" == "" ]; then
	if [ -f ./bin/php7/bin/php ]; then
		export PHPRC=""
		PHP_BINARY="./bin/php7/bin/php"
	elif command -v php >/dev/null 2>&1; then
		PHP_BINARY="$(command -v php)"
	else
		echo "Couldn't find a working PHP binary."
		exit 1
	fi
fi

# ===============================
# POCKETMINE CORE (RENOMBRADOS)
# ===============================
if [ "$POCKETMINE_FILE" == "" ]; then
	if [ -f ./PocketMine-MP.phar ]; then
		POCKETMINE_FILE="./PocketMine-MP.phar"
	elif [ -f ./PocketMine-MP.phar ]; then
		POCKETMINE_FILE="./PocketMine-MP.phar"
	elif [ -f ./src/pocketmine/PocketMine.php ]; then
		POCKETMINE_FILE="./src/pocketmine/PocketMine.php"
	else
		echo "Couldn't find a valid PocketMine installation."
		exit 1
	fi
fi

LOOPS=0
set +e

while [ "$LOOPS" -eq 0 ] || [ "$DO_LOOP" == "yes" ]; do
	if [ "$DO_LOOP" == "yes" ]; then
		"$PHP_BINARY" "$POCKETMINE_FILE" "$@"
	else
		exec "$PHP_BINARY" "$POCKETMINE_FILE" "$@"
	fi

	if [ "$DO_LOOP" == "yes" ]; then
		if [ "$LOOPS" -gt 0 ]; then
			echo "Restarted $LOOPS times"
		fi
		echo "To escape the loop, press CTRL+C now. Otherwise, wait 2 seconds for the server to restart."
		echo ""
		sleep 2
		((LOOPS++))
	fi
done
