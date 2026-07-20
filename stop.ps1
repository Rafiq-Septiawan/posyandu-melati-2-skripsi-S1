Write-Host "================================" -ForegroundColor Cyan
Write-Host "  Posyandu Melati 2 - Stopping" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "Menghentikan semua service..." -ForegroundColor Yellow

taskkill /F /IM php.exe /T 2>$null
taskkill /F /IM ngrok.exe /T 2>$null
Get-Job | Remove-Job -Force 2>$null

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "  Semua service sudah berhenti!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""