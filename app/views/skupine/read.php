<?php 
    require APPROOT . '/views/includes/head.php';
?>

<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Skupina: <?php echo " " . $data['skupina_ime'] ?></h1>
        <h2>Avtor: <?php echo " " . $data['user_id'] ?></h2>
        
    </div>
    
    
</div>