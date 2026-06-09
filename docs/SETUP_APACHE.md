# Setup Apache Virtual Host for Restock Management

This adds a local virtual host `restock.local` that points to the project's `public` folder.

Files created:
- `apache/restock.vhost.conf` : Apache vhost snippet
- `scripts/setup-restock-vhost.ps1` : PowerShell script to append the vhost and hosts entry (run as Administrator)

Steps:

1. Open PowerShell as Administrator.
2. Run:

```powershell
cd D:\Kuliah\PSO\restock-management\scripts
.\setup-restock-vhost.ps1
```

3. Restart Apache (XAMPP Control Panel) or restart the Apache service.
4. Open http://restock.local/login

If your Apache is installed in a different path, edit `scripts/setup-restock-vhost.ps1` and update the `$httpdVhosts` variable.
