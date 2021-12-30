#!/usr/bin/env sh
set -e
set -o pipefail
echo ">>> Running command"
echo ""
sh -c "set -e;  set -o pipefail; cd /var/www; $1"

