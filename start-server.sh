#!/bin/bash
# --- Lấy thư mục chứa script ---
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
echo "Script directory is: $SCRIPT_DIR"

# --- Chạy PHP built-in server ---
php -S localhost:6969 -t "$SCRIPT_DIR"
