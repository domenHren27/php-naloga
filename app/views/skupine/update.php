<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>
    <div>
        <h1>Uredi Skupino</h1>
        <form action="<?php echo URLROOT;?>/skupine/update/ <?php echo $data['skupina']->skupina_id ?>" method="POST">
            <input type="text" placeholder="Ime skupine *" name="skupina_ime" value="<?php echo $data['skupina']->skupina_ime ?>">
            <span class="invalidFeedback">
                <?php echo $data['skupina_imeError'] ?>
            </span>

            <button id="submit" type="submit" value="submit">Submit</button>

        </form>
    </div>
    
    
</div>