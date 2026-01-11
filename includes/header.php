<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Force CSS Reload -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.google.com/css2?family=Noto+JP&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php if(isset($extra_css)) echo $extra_css; ?>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/notifications.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/theme.css?v=<?php echo time(); ?>">
    <script>
        const BASE_PATH = "<?php echo isset($base_path) ? $base_path : ''; ?>";
    </script>
    <title>Food Delivery</title>
</head>
<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">
<script>
    // Apply saved theme immediately to prevent flash
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
</script>
<!-- Duplicate body tag removed -->
  <!-- Checkbox hack removed, handled by JS now -->
  <div class="label-cart" id="cart-toggle-btn" style="cursor: pointer;"><span class="fas fa-shopping-cart"></span></div>
  
    <div class="logo">
        <div id="menu-btn">
            <i class="fas fa-bars"></i>
        </div>
        <img src="<?php echo $base_path; ?>assets/images/logo.png" alt="Food Delivery" style="height: 75px; vertical-align: middle;">
    </div>


