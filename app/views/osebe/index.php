<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>

    <h1>Osebe</h1>

    <?php foreach($data['osebe'] as $oseba): ?>
        <div class="container-item">
            
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $oseba->user_id): ?>
                <?php if(!is_null($oseba->oseba_davcna)): ?>
                    <a
                        class="btn orange"
                        href="<?php echo URLROOT . "/osebe/update_pravna/" . $oseba->oseba_id ?>">
                        Update
                    </a>
                    
                <?php else : ?>
                    <a
                        class="btn orange"
                        href="<?php echo URLROOT . "/osebe/update/" . $oseba->oseba_id ?>">
                        Update
                    </a>
                    
                <?php endif; ?>
                <form action="<?php echo URLROOT . "/osebe/delete/" . $oseba->oseba_id ?>" method="POST">
                        <input type="submit" name="delete" value="Delete" class="btn red">
                </form>
            <?php endif; ?>
            <h1>Ime:</h1>
            <h2>
                <?php echo $oseba->oseba_ime; ?>
            </h2>
            <h1>E-mail:</h1>
            <h2>
                <?php echo $oseba->oseba_email; ?>
            </h2>
            <h1>Telefon:</h1>
            <h2>
                <?php echo $oseba->oseba_telefon; ?>
            </h2>
            <?php if(!is_null($oseba->oseba_davcna)): ?>
                <h1>Davčna številka:</h1>
                <h2>
                    <?php echo $oseba->oseba_davcna; ?>
                </h2>
                    
            <?php endif;?>
            <h2></h2>
        </div>
    <?php endforeach; ?>

    <a href="<?php echo URLROOT;?>/osebe/create">Ustvari osebo</a>
    <a href="<?php echo URLROOT;?>/osebe/create_pravna">Ustvari pravno osebo</a>
</div>