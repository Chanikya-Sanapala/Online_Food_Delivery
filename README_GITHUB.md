# GitHub Update Guide

Since you are working locally in `c:\xampp\htdocs` and you have made many changes (images, logic, database fixes), here is how to upload them to GitHub.

## 1. Add your files
Open your terminal (PowerShell) in `c:\xampp\htdocs` and runs:

```powershell
git add .
```

## 2. Commit your changes
This saves a "snapshot" of your current work:

```powershell
git commit -m "Final polish: fixed images, removed duplicates, zomat-style layout"
```

## 3. Push to GitHub
Upload everything:

```powershell
git push
```

---

### Troubleshooting
*   **"fatal: 'origin' does not appear to be a git repository"**:
    *   This means you haven't linked it to GitHub yet. Go to GitHub.com, create a new repo, copy the URL, and run:
        `git remote add origin https://github.com/YOUR_USER/YOUR_REPO.git`
    *   Then run: `git push -u origin master` (or main)

*   **Authentication Error**:
    *   GitHub doesn't accept passwords anymore. You might need to sign in via the browser pop-up or use a Personal Access Token.
