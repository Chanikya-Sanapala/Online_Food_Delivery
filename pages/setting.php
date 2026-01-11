<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!-- Header -->
    <div class="logo">
        <i class="fas fa-utensils" style="margin-right: 10px; color: var(--primary);"></i> FOOD DELIVERY
    </div>

    <!-- Sidebar / Bottom Nav -->
    <div class="sidebar">
        <div class="sidebar-menu" onclick="window.location.href='homepage.php'">
            <span class="fas fa-home"></span>
            <a href="homepage.php">Home</a>
        </div>
        <div class="sidebar-menu" onclick="window.location.href='search.html'">
            <span class="fas fa-search"></span>
            <a href="search.html">Search</a>
        </div>
        <div class="sidebar-menu" onclick="window.location.href='favorites.html'">
            <span class="fas fa-heart"></span>
            <a href="favorites.html">Favs</a>
        </div>
        <div class="sidebar-menu" onclick="window.location.href='profile.html'">
            <span class="fas fa-user"></span>
            <a href="profile.html">Profile</a>
        </div>
        <div class="sidebar-menu active">
            <span class="fas fa-sliders-h"></span>
            <a href="#">Setting</a>
        </div>
        <div class="sidebar-menu" onclick="window.location.href='logout.php'">
            <span class="fas fa-sign-out-alt"></span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <a href="profile.html" style="font-size: 20px; color: var(--primary);"><i class="fas fa-arrow-left"></i></a>
            <h3 class="dashboard-title" style="margin: 0;">Settings</h3>
        </div>

        <div class="profile-menu"> <!-- Reusing profile-menu class for consistent list style -->
            <a href="#">
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="font-weight:600; font-size:16px;">Add a Place</span>
                    <span style="font-size:13px; color:#888;">In case we’re missing something</span>
                </div>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="#">
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="font-weight:600; font-size:16px;">Places you've added</span>
                    <span style="font-size:13px; color:#888;">See all the places you’ve added so far</span>
                </div>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="profile_change.html">
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="font-weight:600; font-size:16px;">Edit Profile</span>
                    <span style="font-size:13px; color:#888;">Change your name, description and profile photo</span>
                </div>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="#">
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="font-weight:600; font-size:16px;">Notification settings</span>
                    <span style="font-size:13px; color:#888;">Define what alerts and notifications you want to
                        see</span>
                </div>
                <i class="fas fa-chevron-right" style="font-size: 14px;"></i>
            </a>
            <a href="#" style="color: #ff3b30;">
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="font-weight:600; font-size:16px;">Delete Account</span>
                    <span style="font-size:13px; color: #ff3b30; opacity: 0.8;">Permanently delete your account</span>
                </div>
            </a>
        </div>

        <button id="signOut" class="add-btn"
            style="width: 100%; margin-top: 20px; background: #ff3b30; font-size: 16px; padding: 14px;">Sign
            Out</button>

    </div>

    <script>
        // Sign out functionality
        document.getElementById("signOut").addEventListener("click", function () {
            // Redirect to logout script
            window.location.href = "logout.php";
        });
    </script>
</body>

</html>