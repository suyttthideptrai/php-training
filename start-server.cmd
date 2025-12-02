@echo off
REM --- Lấy thư mục chứa script ---
set SCRIPT_DIR=%~dp0
echo Base directory is: %SCRIPT_DIR%

REM --- Chạy PHP built-in server ---
php -S 0.0.0.0:6969 -t "%SCRIPT_DIR%"
