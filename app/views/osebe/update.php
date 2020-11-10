<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Uredi Osebo</h1>
        <form action="<?php echo URLROOT;?>/osebe/<?php if(!is_null($data['oseba']->oseba_davcna)) { echo "update_pravna";} else { echo "update";}  ?>/ <?php echo $data['oseba']->oseba_id ?>" method="POST">
            <input type="text" placeholder="Ime osebe *" name="oseba_ime" value="<?php echo $data['oseba']->oseba_ime ?>">
            <span class="invalidFeedback">
                <?php echo $data['oseba_imeError'] ?>
            </span>
            <input type="text" placeholder="Email osebe *" name="oseba_email" value="<?php echo $data['oseba']->oseba_email ?>">
            <span class="invalidFeedback">
                <?php echo $data['oseba_emailError'] ?>
            </span>
            <input type="text" placeholder="Telefon osebe *" name="oseba_telefon" value="<?php echo $data['oseba']->oseba_telefon ?>">
            <span class="invalidFeedback">
                <?php echo $data['oseba_telefonError'] ?>
            </span>

            <?php if(!is_null($data['oseba']->oseba_davcna)) : ?>
                <input type="text" placeholder="Davcna *" name="oseba_davcna" value="<?php echo $data['oseba']->oseba_davcna ?>">
            <span class="invalidFeedback">
                <?php echo $data['oseba_davcnaError'] ?>
            </span>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/login">Login</a>
            <?php endif; ?>

            <button id="submit" type="submit" value="submit">Submit</button>

        </form>
    </div>
    
    
</div>