<?php 
    require APPROOT . '/views/includes/head.php';
?>


<div id="section-landing">
    <?php 
        require APPROOT . '/views/includes/navigation.php'
    ?>

    <h1>Skupine</h1>

    <?php foreach($data['skupine'] as $skupina): ?>
        <div class="container-item">
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $skupina->user_id): ?>
                <a
                    class="btn orange"
                    href="<?php echo URLROOT . "/skupine/update/" . $skupina->skupina_id ?>">
                    Update
                </a>
                <form action="<?php echo URLROOT . "/skupine/delete/" . $skupina->skupina_id ?>" method="POST">
                    <input type="submit" name="delete" value="Delete" class="btn red">
                </form>
                <a
                    class="btn orange"
                    href="<?php echo URLROOT . "/skupine/oseba_skupina/" . $skupina->skupina_id ?>">
                    Dodaj osebo v skupino
                </a>
            <?php endif; ?>
            <h2>
                <?php echo $skupina->skupina_ime; ?>
            </h2>
        </div>
    <?php endforeach; ?>

    <a href="<?php echo URLROOT;?>/skupine/create">Ustvari skupino</a>
</div>