<div class="sidebar">
    <div class="sidebar-menu <?php echo ($activePage == 'home') ? 'active' : ''; ?>">
        <span class="fas fa-home"></span>
        <a href="<?php echo $base_path; ?>index.php">Home</a>
    </div>
    <div class="sidebar-menu <?php echo ($activePage == 'search') ? 'active' : ''; ?>" onclick="window.location.href='<?php echo $base_path; ?>pages/search.php'">
        <span class="fas fa-search"></span>
        <a href="<?php echo $base_path; ?>pages/search.php">Search</a>
    </div>
    <div class="sidebar-menu <?php echo ($activePage == 'favorites') ? 'active' : ''; ?>" onclick="window.location.href='<?php echo $base_path; ?>pages/favorites.php'">
        <span class="fas fa-heart"></span>
        <a href="<?php echo $base_path; ?>pages/favorites.php">Favs</a>
    </div>
    <div class="sidebar-menu <?php echo ($activePage == 'profile') ? 'active' : ''; ?>" onclick="window.location.href='<?php echo $base_path; ?>pages/profile.php'">
        <span class="fas fa-user"></span>
        <a href="<?php echo $base_path; ?>pages/profile.php">Profile</a>
    </div>
    <div class="sidebar-menu" onclick="window.location.href='<?php echo $base_path; ?>pages/logout.php'">
        <span class="fas fa-sign-out-alt"></span>
        <a href="<?php echo $base_path; ?>pages/logout.php">Logout</a>
    </div>
</div>
