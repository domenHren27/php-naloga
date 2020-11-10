<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Poslji SMS</h1>
        <form action="<?php echo URLROOT;?>/osebe/poslji_sms" method="POST">
            <input type="text" placeholder="Ime osebe *" name="oseba_ime">
            <span class="invalidFeedback">
                <?php echo $data['oseba_imeError'] ?>
            </span>
            <input type="text" placeholder="Sms sporočilo *" name="sms_msg">
            <span class="invalidFeedback">
                <?php echo $data['sms_msgError'] ?>
            </span>
            <span class="sucsess">
                <?php echo $data['sucsses'] ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

        </form>
    </div>
    
    
</div>