<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Ustvari Pravno osebo</h1>
        <form action="<?php echo URLROOT;?>/osebe/create_pravna" method="POST">
            <input type="text" placeholder="Ime osebe *" name="oseba_ime">
            <span class="invalidFeedback">
                <?php echo $data['oseba_imeError'] ?>
            </span>
            <input type="text" placeholder="Email osebe *" name="oseba_email">
            <span class="invalidFeedback">
                <?php echo $data['oseba_emailError'] ?>
            </span>
            <input type="text" placeholder="Telefon osebe *" name="oseba_telefon">
            <span class="invalidFeedback">
                <?php echo $data['oseba_telefonError'] ?>
            </span>
            <input type="text" placeholder="Davčna številka *" name="oseba_davcna">
            <span class="invalidFeedback">
                <?php echo $data['oseba_davcnaError'] ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

        </form>
    </div>
    
    
</div>