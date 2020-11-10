<?php 
    require APPROOT . '/views/includes/head.php';
?>

<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Oseba: <?php echo " " . $data['oseba_ime'] ?></h1>
        
        <h1>Email: <?php echo " " . $data['oseba_email'] ?></h1>
        <h2>Telefon: <?php echo " " . $data['oseba_telefon'] ?></h2>
        <h2>Avtor: <?php echo " " . $data['user_id'] ?></h2>
        
    </div>
    
    
</div>