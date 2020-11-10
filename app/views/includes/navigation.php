 <nav class="top-nav">
     <ul>
         <li>
             <a href="<?php echo URLROOT; ?>/pages/index">Domov</a>
         </li>
         <li>
             <a href="<?php echo URLROOT; ?>/osebe">Osebe</a>
         </li>
         <li>
             <a href="<?php echo URLROOT; ?>/skupine">Skupine</a>
         </li>
         <li>
             <a href="<?php echo URLROOT; ?>/osebe/poslji_sms">Poslji Sms osebi</a>
         </li>
         <li class="btn-login">
            
         <?php if($_SESSION['user_id']) : ?>
                <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/login">Login</a>
            <?php endif; ?>
         </li>
     </ul>

 </nav>