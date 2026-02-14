# sync_prod_to_local.ps1
# Script to SYNC Production Database into Local Laragon

# --- CONFIGURATION ---
$SERVER_IP = "10.88.8.46"
$SSH_USER = "root"
$DB_CONTAINER = "masterdatakpi-db"
$DB_ROOT_PASS = "peronijayajaya123"

# Local Databases to sync
$DATABASES = @("masterdata_kpi", "kpi_bubut")

# Local MySQL (Laragon) - Assuming mysql is in PATH
$MYSQL_PATH = "mysql" 
$LOCAL_ROOT_PASS = "123456788"

# Temporary Directory
$TMP_DIR = "C:\temp_db_sync"
if (!(Test-Path $TMP_DIR)) { New-Item -ItemType Directory -Path $TMP_DIR }

Write-Host "`n--- STARTING PRODUCTION SYNC TO LOCAL ---" -ForegroundColor Cyan

foreach ($DB in $DATABASES) {
    Write-Host "`n>>> Processing Database: $DB" -ForegroundColor Yellow
    
    # 1. SSH Dump
    Write-Host "[1/4] Dumping database on server ($DB)..."
    $DUMP_FILE = "/tmp/${DB}_sync.sql"
    ssh "$SSH_USER@$SERVER_IP" "docker exec $DB_CONTAINER mysqldump -u root -p'$DB_ROOT_PASS' $DB > $DUMP_FILE"

    # 2. SCP Download
    Write-Host "[2/4] Downloading to $TMP_DIR..."
    $LOCAL_FILE = Join-Path $TMP_DIR "${DB}_sync.sql"
    scp "${SSH_USER}@${SERVER_IP}:${DUMP_FILE}" "$LOCAL_FILE"

    # 3. Import Local
    Write-Host "[3/4] Importing into local Laragon ($DB)..."
    # Create DB if not exists
    & $MYSQL_PATH -u root -p"$LOCAL_ROOT_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB;"
    # Import
    Get-Content "$LOCAL_FILE" | & $MYSQL_PATH -u root -p"$LOCAL_ROOT_PASS" $DB

    # 4. Cleanup Server
    Write-Host "[4/4] Cleaning up server temp file..."
    ssh "$SSH_USER@$SERVER_IP" "rm $DUMP_FILE"
}

Write-Host "`n[SUCCESS] Sync completed at $(Get-Date)" -ForegroundColor Green
Write-Host "Local files kept at $TMP_DIR for backup.`n" -ForegroundColor Gray
