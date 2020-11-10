<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <?php echo $data['skupina']->skupina_id ?>
        <h1>Dodaj osebo v skupino</h1>
        <form action="<?php echo URLROOT;?>/skupine/oseba_skupina/<?php echo $data['skupina']->skupina_id ?>" method="POST">
            <input type="text" placeholder="Ime osebe *" name="oseba_ime">
            <span class="invalidFeedback">
                <?php echo $data['oseba_imeError'] ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

        </form>
    </div>
    
    
</div>