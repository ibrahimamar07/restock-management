param()

# Check for admin
function Assert-Admin {
    $current = New-Object Security.Principal.WindowsPrincipal([Security.Principal.WindowsIdentity]::GetCurrent())
    if (-not $current.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)) {
        Write-Error "This script must be run as Administrator. Right-click and 'Run as Administrator'."
        exit 1
    }
}

Assert-Admin

$scriptRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
$vhostFile = Join-Path $scriptRoot "..\apache\restock.vhost.conf"
$vhostFile = (Resolve-Path $vhostFile).ProviderPath

# Default Apache vhosts file used by XAMPP
$httpdVhosts = "C:\\xampp\\apache\\conf\\extra\\httpd-vhosts.conf"
if (-not (Test-Path $httpdVhosts)) {
    Write-Host "Could not find $httpdVhosts. Please update the path in this script to point to your Apache httpd-vhosts.conf file." -ForegroundColor Yellow
    exit 1
}

# Backup
$bak = "$httpdVhosts.bak_$(Get-Date -Format 'yyyyMMddHHmmss')"
Copy-Item $httpdVhosts $bak -Force
Write-Host "Backed up $httpdVhosts to $bak"

# Append vhost if not already present
$vhostText = Get-Content $vhostFile -Raw
if (Select-String -Path $httpdVhosts -Pattern 'restock.local' -Quiet) {
    Write-Host "restock.local vhost already exists in $httpdVhosts" -ForegroundColor Green
} else {
    Add-Content -Path $httpdVhosts -Value "`n# Restock Management vhost`n$vhostText`n"
    Write-Host "Appended restock vhost to $httpdVhosts" -ForegroundColor Green
}

# Add hosts entry
$hostsPath = "C:\\Windows\\System32\\drivers\\etc\\hosts"
$entry = "127.0.0.1`trestock.local"
if (Select-String -Path $hostsPath -Pattern 'restock.local' -Quiet) {
    Write-Host "hosts already contains restock.local" -ForegroundColor Green
} else {
    Add-Content -Path $hostsPath -Value $entry
    Write-Host "Added hosts entry: $entry" -ForegroundColor Green
}

Write-Host "Done. Restart Apache via XAMPP Control Panel or 'net stop apache2.4 & net start apache2.4' if running as a service." -ForegroundColor Cyan
